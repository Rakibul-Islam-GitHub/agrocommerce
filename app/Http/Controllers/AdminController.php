<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Notice;
use App\Review;
use App\Invoice;
use App\Order;
use App\Contact;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function addmanager(){
    	return view('admin.addmanager');
    }

    public function manageradded(Request $req){
		$validate = Validator::make($req->all(), [
			'username' => 'min:3|required|max:50|string',
			'password' => 'required|min:4|required_with:confirmpassword|same:confirmpassword',
			'confirmpassword' => 'required|min:4',
			'email' => 'email|required',
			'phone' => 'required|min:11|max:11',
			'address' => 'string|min:3|required',
            'user_role' => 'string|required',
            'salary' => 'required|min:4'
		]);
		
		if($validate->fails()){
			return redirect()->route('admin.manageradd')->withErrors($validate)->withInput();
		}
		else{
			if(strtolower($req->user_role) == 'admin'){
				$req->session()->flash('re-msg', "You can't register as Admin");
				return redirect()->route("admin.manageradd")->withInput();
            }
            else if(strtolower($req->user_role) == 'customer'){
				$req->session()->flash('re-msg', "You can't register as Customer");
				return redirect()->route("admin.manageradd")->withInput();
            }
            else if(strtolower($req->user_role) == 'seller'){
				$req->session()->flash('re-msg', "You can't register as Seller");
				return redirect()->route("admin.manageradd")->withInput();
			}
			else{
				$user = new User();
				$user->name = $req->username;
				$user->password = $req->password;
                $user->email = $req->email;
                $user->phone = $req->phone;
				$user->address = $req->address;
                $user->role = strtolower($req->user_role);
                $user->salary = strtolower($req->salary);
				$user->save();
				return redirect()->route('admin.index');
			}
		}
    }
    public function userlist(){
        $users  = User::all();
        return view('admin.userlist')->with('users', $users);
    }
    public function userpdf(){
          $users=User::all();
          $pdf = PDF::loadView('admin.pdf',$users)->with('users',$users);
          return $pdf->download('user.pdf');
    }
    public function delete($id){
        
        $users = User::find($id);
        $users->delete();

        //$request->session()->flash('success', "Deleted Succesfully!");
        return redirect()->back();
    }

    public function noticelist(){
        $notice  = Notice::all();
        return view('admin.noticelist')->with('notice', $notice);

    } 

    public function addnotice(){
        return view('admin.addnotice');
    }
    public function noticeadded(Request $req){
		$validate = Validator::make($req->all(), [
			'uid' => 'min:1|required',
			'notice' => 'required|min:10|string'
		]);
		
		if($validate->fails()){
			return redirect()->route('admin.addnotice')->withErrors($validate)->withInput();
		}
		else{
			if($req->uid == 1){
				$notice = new notice();
				$notice->uid = $req->uid;
				$notice->notice = $req->notice;
				$notice->save();
				return redirect()->route('admin.noticelist');
            }
            else {
				$req->session()->flash('re-msg', "You can't give notice");
				return redirect()->route("admin.addnotice")->withInput();
			}
		}
    }
    public function deletenotice($id){
        
        $notice = Notice::find($id);
        $notice->delete();

        //$request->session()->flash('success', "Deleted Succesfully!");
        return redirect()->back();
    }

    public function updf(){
        $users = User::all();
        $pdf = PDF::loadView('pdf.userlist',['users'=>$users])->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('userlist.pdf');
    }
    public function npdf(){
        $notice = Notice::all();
        $pdf = PDF::loadView('pdf.noticelist',['notice'=>$notice])->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('noticelist.pdf');
    }

   /* public function review(){
        $review=Review::all();
        return view('admin.review')->with('review', $review);;

    }*/
    public function reviewdelete($id){
        $review = Review::find($id);
        $review->delete();

        return redirect()->back();
        
    }
    public function invoice(){
        $invoice = Invoice::all();
        $price = DB::table('invoice')->sum('quantity');

        return view('admin.invoice')->with('invoice',$invoice)->with('price',$price);
        
    }
    public function order(){
        $order = Order::all();
        $sum = DB::table('orders')->sum('subtotal');

        return view('admin.order')->with('order',$order)->with('sum',$sum);
        
    }
    public function resetPassword(){

        $user=User::all();
        return view('admin.reset')->with('user',$user);
    }
    public function changePassword(Request $req){
        $checkValidation = Validator::make($req->all(), [
            'password' => 'required|min:4|required_with:repassword|same:repassword',
			'repassword' => 'required|min:4',
        ]);

        if($checkValidation->fails()){
    		return redirect()->route('admin.reset')->withErrors($checkValidation);
        }else{
            DB::table('users')
                        ->where('uid', Session::get('user')->uid)
                        ->update(['password' => $req->password]);
            
    		$req->session()->flash('alert', 'Password Changed!Please Login');
            return redirect()->route('login');
        }

        // return $req->input();
    }

    /////Search
    public function search()
    {
     return view('admin.live_search');
    }

    public function asearch(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('users')
         ->where('name', 'like', '%'.$query.'%')
         ->orWhere('email', 'like', '%'.$query.'%')
         ->orWhere('role', 'like', '%'.$query.'%')
         ->orWhere('salary', 'like', '%'.$query.'%')
         ->orderBy('uid', 'desc')
         ->get();
         
      }
      else
      {
       $data = DB::table('users')
         ->orderBy('uid', 'desc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->name.'</td>
         <td>'.$row->email.'</td>
         <td>'.$row->role.'</td>
         <td>'.$row->salary.'</td>
         <td> 
                <a href="admin/userlist/delete{id}">Delete</a>
            </td>
                  
         
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
/////////////////Message
public function smessage(){
    return view('admin.sentmessage');
}
public function message(Request $req){
$validate = Validator::make($req->all(), [
    'send' => 'min:1|required',
    'to' => 'required|min:10|string',
    'mess'=>'required'
]);

if($validate->fails()){
    return redirect()->route('admin.sendmessage')->withErrors($validate)->withInput();
}
else{
    if($req->send == "a@gmail.com"){
        $contact = new Contact();
        $contact->sender_email = $req->send;
        $contact->receiver_email = $req->to;
        $contact->message = $req->mess;
        $contact->save();
        return redirect()->route('admin.index');
    }
    else {
        $req->session()->flash('re-msg', "You can't give message");
        return redirect()->route("admin.sendmessage")->withInput();
    }
}
}
public function messagelist(Request $req){
    $message = Contact::where('receiver_email',$req->session()->get('email'))->get();
    return view('admin.messagelist')->with('message', $message);
}
////////////////api test////////////

public function review(Request $req){
    $client = new \GuzzleHttp\Client();

$request = $client->get('http://localhost:3000/home/review');
$data =json_decode($request->getBody(),true);
//$admins = $data['user'];
//$data=json_decode($request,true);
 // print_r($data);
  //print_r($data[0]['rid']);
return view('admin.review')->with('review', $data);
}
///////////////////notice search///////////////

public function searchn()
{
 return view('admin.nlive_search');
}

public function nsearch(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('notice')
         ->where('uid', 'like', '%'.$query.'%')
         ->orWhere('notice', 'like', '%'.$query.'%')
         ->orderBy('nid', 'desc')
         ->get();
         
      }
      else
      {
       $data = DB::table('notice')
         ->orderBy('nid', 'desc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->uid.'</td>
         <td>'.$row->notice.'</td>
         <td> 
                <a href="admin/userlist/delete{id}">Delete</a>
            </td>
                  
         
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
}
