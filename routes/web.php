<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login/google', 'loginControllerall@redirectToProvider');
Route::get('/login/google/callback', 'loginControllerall@handleProviderCallback');

Route::get('/login', 'loginControllerall@index')->name('seller.login');
Route::post('/login', 'loginControllerall@verify');
Route::get('/logout', 'logoutController@index')->name('logout');

Route::group(['middleware'=>['sess']], function(){

    Route::group(['middleware'=>['type']], function(){
         
    Route::get('/seller', 'sellerController@index')->name('seller.dashboard');
    Route::get('/seller/additem', 'sellerController@additem')->name('seller.additem');
    Route::get('/seller/manageitem', 'sellerController@manageitem')->name('seller.manageitem');
    Route::get('/seller/manageitem/edit/{id}', 'sellerController@edititem')->name('seller.edititem');
    Route::post('/seller/manageitem/edit/{id}', 'sellerController@updateitem');
    Route::post('/seller/manageitem/soldout', 'sellerController@soldout');
    Route::put('/seller/manageitem/stockavailable', 'sellerController@stockavailable');
    Route::get('/seller/manageitem/delete', 'sellerController@itemdelete');
    Route::get('/seller/review', 'sellerController@review')->name('seller.review');
    Route::post('/seller/review/delete', 'sellerController@reviewdelete');
    Route::get('/seller/order', 'sellerController@order')->name('seller.order');
    Route::put('/seller/order/approveorder', 'sellerController@approveorder')->name('seller.order');
    Route::post('/seller/additem', 'sellerController@itemstore');
    Route::get('/seller/profile', 'sellerController@profile')->name('seller.profile');
    Route::post('/seller/profile', 'sellerController@profileupdate')->name('seller.profileupdate');
    Route::get('/seller/message', 'sellerController@message')->name('seller.message');
    Route::post('/seller/message', 'sellerController@messagestore');
    Route::post('/seller/messageshow', 'sellerController@messageshow');
    Route::get('/seller/category', 'sellerController@guzzlereq')->name('seller.category');
    Route::post('/seller/category/delete', 'sellerController@categorydelete');
    Route::post('/seller/addcategory', 'sellerController@addcategory');
    Route::get('/seller/getap', 'sellerController@getapproval');
    Route::get('/seller/excelreport', 'sellerController@excelreport')->name('excel');

    });
	
	// customer routes
	Route::get('/logout2', 'LogoutController@index')->name('customer.logout');
	 Route::get('/home', 'CustomerController@home')->name('customer.home');
    Route::get('/searchProducts', 'CustomerController@searchProducts')->name('customer.searchProducts');

    Route::get('/cart', 'CustomerController@cart')->name('customer.cart');
    Route::post('/cart', 'CustomerController@order')->name('customer.order');
    Route::get('/add-to-cart/{pid}', 'CustomerController@addToCart')->name('customer.add-to-cart');
    Route::get('/add-by-one/{pid}', 'CustomerController@addByOne')->name('customer.add-by-one');
    Route::get('/reduce-by-one/{pid}', 'CustomerController@reduceByOne')->name('customer.reduce-by-one');
    Route::get('/remove/{pid}', 'CustomerController@remove')->name('customer.remove');
    
    Route::get('/history', 'CustomerController@history')->name('customer.history');
    Route::get('/order_details/{oid}', 'CustomerController@order_details')->name('customer.order_details');
    Route::post('/order_details/{oid}', 'CustomerController@add_review')->name('customer.order_details');
    Route::get('/generate_pdf/{oid}', 'CustomerController@generate_pdf')->name('customer.generate_pdf');

    Route::get('/view_product_review/{pid}', 'CustomerController@view_product_review')->name('customer.view_product_review');
    
    Route::post('/editProfile', 'CustomerController@editProfile')->name('customer.editProfile');
    Route::post('/contact', 'CustomerController@contact')->name('customer.contact');

    Route::get('/view_emails', 'CustomerController@view_emails')->name('customer.view_emails');
    Route::get('/view_notice', 'CustomerController@view_notice')->name('customer.view_notice');
    
    // node app
    Route::get('/view_node_news', 'CustomerController@view_node_news')->name('customer.view_node_news');
	
	
	// coustomer routes end

   //admin route start
   Route::get('/admin/home', 'AdminController@index')->name('admin.index');
Route::get('/admin/addmanager', 'AdminController@addmanager')->name('admin.manageradd');
Route::post('/admin/addmanager', 'AdminController@manageradded');
Route::get('/admin/userlist', 'AdminController@userlist')->name('userlist');
Route::get('/admin/userpdf', 'AdminController@userpdf')->name('userpdf');
Route::get('/admin/userlist/delete{id}', 'AdminController@delete')->name('admin.delete');
Route::get('/admin/noticelist', 'AdminController@noticelist')->name('admin.noticelist');
Route::get('/admin/notice/add', 'AdminController@addnotice')->name('admin.addnotice');
Route::post('/admin/notice/add', 'AdminController@noticeadded');
//Route::get('/admin/notice/add', 'AdminController@addnotice')->name('admin.addnotice');
Route::get('/admin/notice/delete{id}', 'AdminController@deletenotice')->name('notice.delete');
Route::get('admin/updf','AdminController@updf')->name('updf');
Route::get('admin/npdf','AdminController@npdf')->name('npdf');
Route::get('admin/review','AdminController@review')->name('review');
Route::get('admin/review/delete{id}','AdminController@reviewdelete')->name('review.delete');
Route::get('admin/invoice','AdminController@invoice')->name('review.invoice');
Route::get('admin/order','AdminController@order')->name('admin.order');
Route::get('admin/reset','AdminController@resetPassword')->name('admin.reset');
Route::post('admin/reset','AdminController@changePassword');
Route::get('admin/search','AdminController@search')->name('admin.search');
Route::get('admin/usersearch','AdminController@asearch')->name('admin.usersearch');
//{{route('admin.nsearch')}}
Route::get('admin/nsearch','AdminController@searchn')->name('admin.nosearch');
Route::get('admin/noticesearch','AdminController@nsearch')->name('admin.noticesearch');

Route::get('admin/send/message','AdminController@smessage')->name('admin.sendmessage');
Route::post('admin/send/message','AdminController@message');
Route::get('admin/messagelist','AdminController@messagelist')->name('admin.message');

// admin route end

// manager route start
Route::get('/manager/home', 'managerController@index')->name('home.index');
    //Notice
    Route::get('/notice', 'managerController@getNotice')->name('manager.notice');
    Route::get('/notice/edit/{id}', 'managerController@edit')->name('home.edit');
    Route::post('/notice/edit/{id}', 'managerController@update');
    Route::get('/notice/delete/{id}', 'managerController@delete');
    Route::get('/notice/create', 'managerController@noticeCreate')->name('notice.create');
    Route::post('/notice/create', 'managerController@NoticeCreatePost');
    //News
    Route::get('/news', 'managerController@getNews')->name('manager.news');
    Route::get('/news/create', 'managerController@createNews')->name('manager.news.create');
    Route::post('/news/create', 'managerController@createNewsPost');
    Route::get('/news/edit/{id}', 'managerController@editNews')->name('manager.news.edit');
    Route::post('/news/edit/{id}', 'managerController@editNewsPost');
    Route::get('/news/delete/{id}', 'managerController@deleteNews')->name('manager.news.delete');
    //contact
    Route::get('/manager/admin', 'managerController@admin')->name('contact.admin');
    Route::get('/manager/buyer', 'managerController@buyer')->name('contact.buyer');
    Route::get('/manager/seller', 'managerController@seller')->name('contact.seller');
    //message
    Route::get('/message/{email}', 'managerController@message')->name('manager.message');
    Route::post('/message/{email}', 'managerController@messagePost');
    //review
    Route::get('/manager/review', 'managerController@review')->name('manager.review');
    Route::get('/review/delete/{id}', 'managerController@reviewDelete');
    //search
    Route::get('/search', 'managerController@search')->name('manager.search');
    //pdf
    Route::get('/news/pdf/{id}', 'managerController@pdfCreate')->name('manager.pdf');
    //my message
    Route::get('/manager/message', 'managerController@myMessage')->name('manager.myMessage');

// manager route end
    
});
