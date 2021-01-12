<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Socialite;
use App\Users;
use App\Products;
use App\Orders;
use App\Invoice;
use App\Order_history;
use App\Review;
use App\Contact;
use App\Notice;

use App\Cart;

class CustomerController extends Controller
{
    public function index(Request $req)
    {
        return view('customer.index');
    }
    public function github(Request $req)
    {
        return Socialite::driver('github')->redirect();
    }
    public function githubRedirect(Request $req)
    {
        $user= Socialite::driver('github')->user();    
        // shows data  
        // dd($user);
        // shows data  

        $getUser=Users::all()->where('email', $user->email);
        if(count($getUser)==0){   
            $newUser = new Users();
            $newUser->name = $user->name;
            $newUser->role = 'customer';
            $newUser->salary = 0;
            $newUser->phone = '';
            $newUser->email = $user->email;
            $newUser->address = $user->user['location'];
            $newUser->password = '123';
            $newUser->save();

            $req->session()->flash('msg',$newUser->name.' ('.$newUser->role.') is registered.');
            $req->session()->flash('type','success');
        }else{
            $req->session()->flash('msg', 'GitHub login successful.');
            $req->session()->flash('type','success');
        }
        $getUser=Users::where('email', $user->email)->get();
        $req->session()->put('profile',$getUser[0]);        
        $req->session()->put('role',$getUser[0]->role);
        return redirect()->route('customer.home');
    }
    public function home(Request $req)
    {
        $products=Products::all();
        return view('customer.home')->with('products',$products);
    }
    public function searchProducts(Request $req)
    {
        $searchKey = $req->get('searchKey');
        if($req->ajax()){
            $products=Products::where('title','like', '%'.$searchKey.'%')->get();
            echo json_encode($products); 
        }   
    }
    public function cart(Request $req)
    {
        $cart=$req->session()->get('cart');
        $cartData=[];
        $totalPrice=0;
        if($cart!=null){
            for($i=0; $i<count($cart); $i++){
                $pid=$cart[$i][0];

                $product=Products::where('pid', $pid)->get();
                if(count($product)!=0){
                    $title=$product[0]->title;
                    $shop_name=$product[0]->shop_name;
                    $price=$product[0]->price;

                    $qty=$cart[$i][1];
                    $totalPrice= $totalPrice + ($qty*$price);
                    $item=[$pid, $title, $shop_name, $qty, $price];
                    array_push($cartData,$item); 
                }           
            }
            // print_r($cartData);
            // echo $totalPrice;
        }  
        return view('customer.cart')->with('cartData',$cartData)->with('totalPrice',$totalPrice);
        
    }
    public function addToCart(Request $req, $pid)
    {   
               //[[pid,qty]]
        // $cart=[[1,2],[8,9]];
        
        if($req->session()->get('cart')==null){
            $c= new Cart(null);
            $newCart=$c->add($pid);
            $req->session()->put('cart',$newCart);
        }else{
            $oldCart=$req->session()->get('cart');
            $c= new Cart($oldCart);
            $newCart=$c->add($pid);
            $req->session()->put('cart',$newCart);
        }
        
        $req->session()->flash('msg', 'Product added to cart.');
        $req->session()->flash('type','success');
        return redirect()->route('customer.home');            
        
    }
    // the method addByOne is same as addToCart. but return view is in cart page
    public function addByOne(Request $req, $pid)
    {   
               //[[pid,qty]]
        // $cart=[[1,2],[8,9]];
        
        if($req->session()->get('cart')==null){
            $c= new Cart(null);
            $newCart=$c->add($pid);
            $req->session()->put('cart',$newCart);
        }else{
            $oldCart=$req->session()->get('cart');
            $c= new Cart($oldCart);
            $newCart=$c->add($pid);
            $req->session()->put('cart',$newCart);
        }
        
        $req->session()->flash('msg', 'Product Id('.$pid.') added by one.');
        $req->session()->flash('type','warning');
        return redirect()->route('customer.cart');            
        
    }
    // the method addByOne is same as addToCart. but return view is in cart page
    
    public function reduceByOne(Request $req, $pid)
    {   
               //[[pid,qty]]
        // $cart=[[1,2],[8,9]];        
        
        $oldCart=$req->session()->get('cart');
        $c= new Cart($oldCart);
        $newCart=$c->reduce($pid);
        $req->session()->put('cart',$newCart);
        
        
        $req->session()->flash('msg', 'Product Id('.$pid.') reduced by one.');
        $req->session()->flash('type','warning');
        return redirect()->route('customer.cart'); 
        
    }

    public function remove(Request $req, $pid)
    {   
               //[[pid,qty]]
        // $cart=[[1,2],[8,9]];        
        
        $oldCart=$req->session()->get('cart');
        $c= new Cart($oldCart);
        $newCart=$c->remove($pid);
        $req->session()->put('cart',$newCart);
        
        
        $req->session()->flash('msg', 'Product Id('.$pid.') removed.');
        $req->session()->flash('type','warning');
        return redirect()->route('customer.cart');        
    }
    public function order(Request $req)
    {  
        $req->validate([
            'shipping_method' => 'required'          
        ]); 
        


        $cart=$req->session()->get('cart');
        $order=[];
        $totalPrice=0;
        if($cart!=null){
            for($i=0; $i<count($cart); $i++){
                $pid=$cart[$i][0];

                $product=Products::where('pid', $pid)->get();
                if(count($product)!=0){
                    $sellerid=$product[0]->sellerid;
                    $price=$product[0]->price;

                    $qty=$cart[$i][1];
                    $totalPrice= $totalPrice + ($qty*$price);
                    $purchase=[$sellerid, $qty, $price];
                    array_push($order,$purchase); 
                }           
            }
            
            // checking items available or not
            if($totalPrice==0){
                $req->session()->flash('msg', 'Failed. No items selected.');
                $req->session()->flash('type','danger');
                return back();
            }
            // checking items available or not


            $newOrder = new Orders();
            $newOrder->customerid = $req->session()->get('profile')->uid;
            $newOrder->date = NOW();
            $newOrder->subtotal = $totalPrice;
            $newOrder->shipping_method = $req->shipping_method;
            $newOrder->status = 'pending';
            $newOrder->save();
            $lastOrder=DB::table('orders')
                ->select('oid')
                ->where('customerid',$req->session()->get('profile')->uid)
                ->where('status', 'pending')
                ->orderBy('oid', 'desc')
                ->first();

            $oid=$lastOrder->oid;

            //adding to invoice
            for($i=0; $i<count($order); $i++){
                $newInvoice = new Invoice();
                $newInvoice->oid = $oid;
                $newInvoice->sellerid = $order[$i][0];
                $newInvoice->quantity = $order[$i][1];
                $newInvoice->price = $order[$i][2];
                $newInvoice->save();
            }
            
            $req->session()->forget('cart');
        }
        
        $req->session()->flash('msg', 'Order confirmed.');
        $req->session()->flash('type','success');
        return redirect()->route('customer.cart');        
    }
    public function history(Request $req)
    {
        $orders=Orders::all()->where('customerid', $req->session()->get('profile')->uid);
        return view('customer.history')->with('orders',$orders);
        
    }  
    public function order_details(Request $req, $oid)
    {
        $orderDetails = DB::select("SELECT orders.oid, pid,title, invoice.sellerid, shop_name, quantity, invoice.price, subtotal, date, shipping_method, orders.status FROM invoice,orders,products where invoice.oid=orders.oid and invoice.sellerid=products.sellerid and orders.oid=?", [$oid]);
        // print_r ($users[0]->title);
        return view('customer.orderDetails')->with('orderDetails',$orderDetails);
        
    }  
    public function generate_pdf(Request $req, $oid)
    {
        $orderDetails = DB::select("SELECT orders.oid, pid,title, invoice.sellerid, shop_name, quantity, invoice.price, subtotal, date, shipping_method, orders.status FROM invoice,orders,products where invoice.oid=orders.oid and invoice.sellerid=products.sellerid and orders.oid=?", [$oid]);
        // print_r ($users[0]->title);
        // return view('customer.orderDetails')->with('orderDetails',$orderDetails);
        
        $data= "<h1 style='text-align: center; margin-bottom: 100px;'>Agro-Commers</h1>".
        $data= "<h3 style='color:red;'>Order Details:</h3>".
                "<table border='1' style='margin-left: auto; margin-right: auto;'>".
                    "<thead>".
                      "<tr>".
                        "<th scope='col'>oid</th>".
                        "<th scope='col'>Title</th>".
                        "<th scope='col'>Seller Id</th>".
                        "<th scope='col'>Shop</th>".
                        "<th scope='col'>Quantity</th>".
                        "<th scope='col'>Price</th>".
                        // "<th scope='col'>Total</th>".
                        "<th scope='col'>Order Date</th>".
                        "<th scope='col'>Shipping Method</th>".
                        "<th scope='col'>Status</th>".
                      "</tr>".
                    "</thead>".
                    "<tbody>";
                    $subtotal=0;
                    for($i=0; $i<count($orderDetails); $i++){
                      $rows="<tr>".
                        "<th>".$orderDetails[$i]->oid."</th>".
                        "<td>".$orderDetails[$i]->title."</td>".
                        "<td>".$orderDetails[$i]->sellerid."</td>".
                        "<td>".$orderDetails[$i]->shop_name."</td>".
                        "<td>".$orderDetails[$i]->quantity."</td>".
                        "<td>".$orderDetails[$i]->price ."/=</td>".
                        // "<td>".$orderDetails[$i]->subtotal ."/=</td>".
                        "<td>".$orderDetails[$i]->date."</td>".
                        "<td>".$orderDetails[$i]->shipping_method."</td>".
                        "<td>".$orderDetails[$i]->status."</td>".
                      "</tr>";
                      $subtotal=$orderDetails[$i]->subtotal;
                      $data=$data.$rows;
                    }                    
                    $data=$data."</tbody>".
                    "</table>".
                    "<h3 style='color: #117a8b; float:right;'>Total: ".$subtotal."/= Taka</h3>";
                //   echo $data;
                //--------------------PDF generation--------------------
                $pdf= \PDF::loadHTML($data);        
                return $pdf->stream();
                  
        
    } 
    public function add_review(Request $req)
    {
        $req->validate([
            'pid' => 'required',          
            'review' => 'required'          
        ]); 
        $sellerid = DB::select("select sellerid from products where pid=?", [$req->pid]);
        $sellerid= $sellerid[0]->sellerid;
        // echo $sellerid;

        $newReview = new Review();
        $newReview->customerid = $req->session()->get('profile')->uid;
        $newReview->sellerid = $sellerid;
        $newReview->productid = $req->pid;
        $newReview->review = $req->review;
        $newReview->date = NOW();        
        $newReview->save();
        
        $req->session()->flash('msg', 'Review added.');
        $req->session()->flash('type','success');
        return back();
        
    }
    public function view_product_review(Request $req, $pid)
    {
        $product = DB::select("select * from products where pid=?", [$req->pid]);
        // echo $product[0];

        $productReviews = DB::select("select * from review where productid=?", [$req->pid]);
        return view('customer.review')
            ->with('productReviews',$productReviews)
            ->with('product',$product[0]);
    }  
    public function editProfile(Request $req)
    {
        $req->validate([
            'name' => 'required',          
            'email' => 'required|email|unique:users,email,'.$req->session()->get('profile')->uid.',uid',       
            'address' => 'required',          
            'password' => 'required',          
            'phone' => 'required|min:11|unique:users,phone,'.$req->session()->get('profile')->phone.',phone'          
        ]); 

        $user = Users::find($req->session()->get('profile')->uid);
        $user->name         = $req->name;
        $user->email     = $req->email;
        $user->address     = $req->address;
        $user->password    = $req->password;
        $user->phone         = $req->phone;
        $user->save();
        
        $getUser=Users::where('uid', $req->session()->get('profile')->uid)->get();
        $req->session()->put('profile',$getUser[0]);        
        $req->session()->put('role',$getUser[0]->role);

        $req->session()->flash('msg','Profile updated successfully.');
        $req->session()->flash('type','success');            
        return redirect()->route('customer.home');
    }  
    public function contact(Request $req)
    {
        $req->validate([         
            'receiver_email' => 'required|email|exists:users,email',       
            'message' => 'required'
        ]); 

        $newContact = new Contact();
        $newContact->sender_email = $req->session()->get('profile')->email;
        $newContact->receiver_email = $req->receiver_email;
        $newContact->message = $req->message;
        $newContact->save();

        $req->session()->flash('msg','Message sent.');
        $req->session()->flash('type','success');            
        return redirect()->route('customer.home');
    } 
    public function view_emails(Request $req)
    {
        $contacts = Contact::where('receiver_email', $req->session()->get('profile')->email)->get();
        return view('customer.emails')->with('contacts',$contacts);
    } 
    public function view_notice(Request $req)
    {
        $notices = Notice::get();
        return view('customer.notice')->with('notices',$notices);
    } 

    // -------------Getting from node app-------
    public function view_node_news(Request $req)
    {
        $client=new \GuzzleHttp\Client();
        $reqAPI=$req;
        $reqAPI=$client->get('http://localhost:1000/customer/news');
        $response=$reqAPI->getBody();
        // echo $response;
        $arrNews=json_decode($response);
        // print_r($arrNews[0]->headline);

        $req->session()->flash('msg','API connected & got data from node application.');
        $req->session()->flash('type','success');
        return view('customer.nodeNews')->with('arrNews',$arrNews);

        
    } 
    // -------------Getting from node app-------
}
