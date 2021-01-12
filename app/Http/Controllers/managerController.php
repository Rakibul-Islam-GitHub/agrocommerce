<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Validator;
use PDF;
use App\Notice;
use App\News;
use App\Review;
use App\Contact;
use App\User;
use Illuminate\Support\Facades\DB;

class managerController extends Controller
{

    function index(Request $req){
        $name = $req->session()->get('name');
        return view('home.index', compact('name'));
    }

    public function getNotice(){
         //$users = DB::table('notice')->get();
         //$array=(array) $users;
         $users  = Notice::all();
        return view('home.noticelist')->with('users', $users);
    }

    public function edit($id){ 
       $user = Notice::find($id);
       //debug_to_console($user);      
        return view('home.edit', $user);
        //return view('home.edit');
    }

    public function update($id, UserRequest $req){

        $user = Notice::find($id); 
        $user->nid    = $req->nid;
        $user->uid    =  $req->uid;
        $user->notice = $req->notice;
        $user->save();

        return redirect()->route('manager.notice');
    }


public function delete($id){
          Notice::destroy($id);
        return redirect()->route('manager.notice');
    }

 public function noticeCreate(){
        return view('home.create');
    }


public function NoticeCreatePost(Request $req){

	$validation = Validator::make($req->all(),[
            'notice' => 'required | min : 3',
            
        ]);

        if($validation->fails()){
            return back()
                    ->with('errors',$validation->errors());
        }
        else{

	             $user = new Notice();
                $user->uid     = $req->session()->get('uid');
                $user->notice   = $req->notice;

                if($user->save()){
                    return redirect()->route('manager.notice');
                }else{
                    return back();
                }
            }

}

public function search(Request $req)
    {   $key = $req->get('key');
        if($req->ajax()){
            $allUsers=Notice::where('notice','like', '%'.$key.'%')->get();

            echo json_encode($allUsers);    
        }
    }

public function getNews(){
         //$users = DB::table('notice')->get();
         //$array=(array) $users;
         $users  = News::all();
        return view('home.newslist')->with('users', $users);
    }

public function createNews(){
        return view('home.newscreate');
    }
public function createNewsPost(Request $req){

	$validation = Validator::make($req->all(),[
            'detail' => 'required | min : 5',
             'date' => 'required ',
              'headline' => 'required | min : 3',
            
        ]);

        if($validation->fails()){
            return back()
                    ->with('errors',$validation->errors());
        }
        else{

	    $user = new News(); 
        $user->newsid    = $req->newsid;
        $user->date    =  $req->date;
        $user->headline = $req->headline;
         $user->detail = $req->detail;

                if($user->save()){
                    return redirect()->route('manager.news');
                }else{
                    return back();
                }
            }

}
public function editNews($id){ 
       $user = News::find($id);
       //debug_to_console($user);      
        return view('home.editnews', $user);
        //return view('home.edit');
    }

    public function editNewsPost($id,Request $req){

	$validation = Validator::make($req->all(),[
            'detail' => 'required | min : 5',
             'date' => 'required ',
              'headline' => 'required | min : 3',
            
        ]);

        if($validation->fails()){
            return back()
                    ->with('errors',$validation->errors());
        }
        else{
                  $user = News::find($id); 
	             //$user = new News();
                $user->date     = $req->date;
                $user->headline   = $req->headline;
                $user->detail   = $req->detail;

                if($user->save()){
                    return redirect()->route('manager.news');
                }else{
                    return back();
                }
            }
}

public function deleteNews($id){
          News::destroy($id);
        return redirect()->route('manager.news');
    }
   public function pdfCreate($id){
   	$data = News::find($id);
    $pdf = PDF::loadView('home.exportdata',compact('data'));
    return $pdf->download('students.pdf');
   }


public function admin(){
	$users = User::where('role','admin')->get();
	return view('home.adminlist')->with('users', $users);
}

public function buyer(){
	$users = User::where('role','buyer')->get();
	return view('home.buyerlist')->with('users', $users);
}

public function seller(){
	$users = User::where('role','seller')->get();
	return view('home.sellerlist')->with('users', $users);
}

   public function message($email){
   	return view('home.message');
   }

public function messagePost($email,Request $req){
	$validation = Validator::make($req->all(),[
            'message' => 'required | min : 5',
            
        ]);

        if($validation->fails()){
            return back()
                    ->with('errors',$validation->errors());
        }
        else{

	             $user = new Contact();
                $user->sender_email     = $req->session()->get('email');
                $user->receiver_email   = $email;
                $user->message   = $req->message;

                if($user->save()){
                    return redirect()->route('home.index');
                }else{
                    return back();
                }
            }
}


public function review(Request $req){
	    $client = new \GuzzleHttp\Client();

    $request = $client->get('http://localhost:3000/home/review');
    $data =json_decode($request->getBody(),true);
    //$admins = $data['user'];
    //$data=json_decode($request,true);
     // print_r($data);
      //print_r($data[0]['rid']);
    return view('home.review')->with('users', $data);
}

public function reviewDelete($id){
	      Review::destroy($id);
        return redirect()->route('manager.review');

}
public function myMessage(Request $req){
    $users = Contact::where('receiver_email',$req->session()->get('email'))->get();
    return view('home.contact')->with('users', $users);
}








    public function store(UserRequest $req){
        
       /* $validation = Validator::make($req->all(), [
            'name' => 'required|min:3',
            'email'=> 'required',
            'cgpa' => 'required'
        ]);
        if($validation->fails()){
            return redirect()
                    ->route('home.create')
                    ->with('errors', $validation->errors())
                    ->withInput();
            return back()
                    ->with('errors', $validation->errors())
                    ->withInput();
        }*/


       /* $this->validate($req, [
            'name' => 'required|min:3',
            'email'=> 'required',
            'cgpa' => 'required'
        ])->validate();*/


        /*$req->validate([
            'name' => 'required|min:3',
            'email'=> 'required',
            'cgpa' => 'required'
        ])->validate();*/


        if($req->hasFile('myimg')){

        	$file = $req->file('myimg');
        	/*echo "File Name: ".$file->getClientOriginalName()."<br/>";
        	echo "File Extension: ".$file->getClientOriginalExtension()."<br/>";
        	echo "File Size: ".$file->getSize();*/

        	if($file->move('upload', $file->getClientOriginalName())){
        		
                $user = new User();
                $user->username     = $req->username;
                $user->password     = $req->password;
                $user->name         = $req->name;
                $user->dept         = $req->dept;
                $user->cgpa         = $req->cgpa;
                $user->type         = $req->type;
                $user->profile_img  = $file->getClientOriginalName();

                if($user->save()){
                    return redirect()->route('home.userlist');
                }else{
                    return back();
                }

        	}else{
        		return back();
        	}
        }
    }

    public function userlist(){
        $users  = User::all();
        return view('home.userlist')->with('users', $users);
    }

    public function show($id){
        //$user = $id
    	$user = ['id'=> 1, 'name'=>'xyz', 'email'=>'xyz@aiub.edu', 'cgpa'=>4, 'img'=>'abc.png'];
        return view('home.show', $user);
    }
    private function getUserlist(){
        return [
            ['id'=> 1, 'name'=>'xyz', 'email'=>'xyz@aiub.edu', 'cgpa'=>4],
            ['id'=> 2, 'name'=>'abc', 'email'=>'abc@aiub.edu', 'cgpa'=>3],
            ['id'=> 3, 'name'=>'asd', 'email'=>'asd@aiub.edu', 'cgpa'=>3.5],
            ['id'=> 4, 'name'=>'pqr', 'email'=>'pqr@aiub.edu', 'cgpa'=>2.4],
            ['id'=> 5, 'name'=>'alamin', 'email'=>'alamin@aiub.edu', 'cgpa'=>1.2]
        ];
    }
}