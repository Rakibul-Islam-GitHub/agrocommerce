<!-- editProfile trigger modal -->
@include ('customer.editProfile')
<!-- contact trigger modal -->
@include ('customer.contact')

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Agro-Commers</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/styles.css" rel="stylesheet" />
        <link href="/css/styles2.css" rel="stylesheet" />
        
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="{{route('customer.home')}}">Agro-Commers</a>
                <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars m-0 p-0 mx-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a href="#page-top" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"><i class="fa fa-user mr-1 pr-1" aria-hidden="true"></i>Welcome, {{session('profile.name')}} </a></li>
                        <!-- editProfile Button trigger modal -->
                        <li class="nav-item mx-0 mx-lg-1"><a href="#" data-toggle="modal" data-target="#editProfile" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"><i class="fas fa-user-edit mr-1 pr-1"></i>Profile</a></li>
                        <!-- contact Button trigger modal -->
                        <li class="nav-item mx-0 mx-lg-1"><a href="#" data-toggle="modal" data-target="#contact" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"><i class="fas fa-envelope mr-1 pr-1"></i>Contact</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a href="{{route('customer.logout')}}" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"><i class="fas fa-sign-out-alt mr-1 pr-1"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>




               <!--Body Section-->
        <section class="page-section portfolio" id="portfolio">
            <div class="container">
            <a href="{{route('customer.view_node_news')}}" class="float-right mt-2 mt-md-4 mt-lg-5 body-a"><i class="fas fa-newspaper"></i> News</a>
                <a href="{{route('customer.view_notice')}}" class="float-right mt-2 mt-md-4 mt-lg-5 mr-3 body-a"><i class="fas fa-volume-up"></i> Notice</a>
                <a href="{{route('customer.view_emails')}}" class="float-right mt-2 mt-md-4 mt-lg-5 mr-3 body-a"><i class="fas fa-envelope"></i> Emails</a>
                <a href="{{route('customer.history')}}" class="float-right mt-2 mt-md-4 mt-lg-5 mr-3 body-a active"><i class="fas fa-history"></i> History</a>
                <a href="{{route('customer.cart')}}" class="float-right mt-2 mt-md-4 mt-lg-5 mr-3 body-a"><i class="fas fa-shopping-cart"></i> Cart</a>
            </div>
        </section>




        
                <!--Body Section 2  -->
        <section class="page-section portfolio p-3 mb-5" id="portfolio">
            <div class="container">

                @if(count($errors)>0)
                    <div class="alert alert-danger p-3 mb-4" role="alert">
                    @foreach($errors->all() as $err)
                    {{$err}} <br>
                    @endforeach
                    </div>
                @endif

                @if(session('msg'))
                <div class="'alert alert-{{session('type')}} p-3 mb-4" role="alert">
                {{session('msg')}}
                </div>
                @endif

                <div class='text-info h6'>Order Details:</div>
                <table class="table table-borderless table-hover shadow">
                    <thead>
                      <tr>
                        <th scope="col">oid</th>
                        <th scope="col">Title</th>
                        <th scope="col">Seller Id</th>
                        <th scope="col">Shop</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Shipping Method</th>
                        <th scope="col">Status</th>
                        <th scope="col">Review</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    @for($i=0; $i<count($orderDetails); $i++)
                      <tr>
                        <th>{{$orderDetails[$i]->oid}}</th>
                        <td>{{$orderDetails[$i]->title}}</td>
                        <td>{{$orderDetails[$i]->sellerid}}</td>
                        <td>{{$orderDetails[$i]->shop_name}}</td>
                        <td>{{$orderDetails[$i]->quantity}}</td>
                        <td>{{$orderDetails[$i]->price}} ৳</td>
                        <td>{{$orderDetails[$i]->subtotal}} ৳</td>
                        <td>{{$orderDetails[$i]->date}}</td>
                        <td>{{$orderDetails[$i]->shipping_method}}</td>
                        <td>{{$orderDetails[$i]->status}}</td>
                        <td>
                        <!-- add review form -->
                        <form method="post">
                        @csrf
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#addreview-{{$i}}">
                            Add                
                        </button>
                        <!-- Modal -->                
                        <div class="modal fade" id="addreview-{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Review</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!--  -->
                                <label><b>Title:</b> {{$orderDetails[$i]->title}}</label>
                                <br>
                                <label><b>Shop Name:</b> {{$orderDetails[$i]->shop_name}}</label>
                                <br>
                                <div class="form-group">
                                    <!-- <label><b>Product ID:</b></label> -->
                                    <input name='pid' value='{{$orderDetails[$i]->pid}}'  class="form-control form-control-sm" type="hidden" placeholder=".form-control-sm">

                                    <label for="exampleFormControlTextarea1"><b>Review:</b></label>
                                    <textarea name='review' class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <!--  -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        </form>
                        <!-- add review form -->
                        </td>
                      </tr>
                    @endfor
                    
                    </tbody>
                  </table>
               
                
                
                






            </div>
        </section>






        <!-- Footer-->
        <footer class="footer text-center">
            <div class="container">
                <div class="row">
                    <!-- Footer Location-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="text-uppercase mb-4">Location</h4>
                        <p class="lead mb-0">
                            1212 Gulshan-2
                            <br />
                            Dhaka, Bangladesh
                        </p>
                    </div>
                    <!-- Footer Social Icons-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="text-uppercase mb-4">Around the Web</h4>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-dribbble"></i></a>
                    </div>
                    <!-- Footer About Text-->
                    <div class="col-lg-4">
                        <h4 class="text-uppercase mb-4">About</h4>
                        <p class="lead mb-0">
                            We sell all types of agricultural products. For any problem please contact with this email smith@gmail.com (manager);
                        </p>
                        <p class="lead mt-4">
                           For any problem please contact with this email smith@gmail.com (manager);
                        </p>
                    </div>
                </div>
            </div>
        </footer>








        <!-- Copyright Section-->
        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright © AGRO-COMMERS 2020</small></div>
        </div>
        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
        <div class="scroll-to-top d-lg-none position-fixed">
            <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a>
        </div>
        
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Core theme JS-->
        <script src="/js/scripts.js"></script>
    </body>
</html>