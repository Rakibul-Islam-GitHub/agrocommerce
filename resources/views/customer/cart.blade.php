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
                <a href="{{route('customer.history')}}" class="float-right mt-2 mt-md-4 mt-lg-5 mr-3 body-a"><i class="fas fa-history"></i> History</a>
                <a href="{{route('customer.cart')}}" class="float-right mt-2 mt-md-4 mt-lg-5 mr-3 body-a active"><i class="fas fa-shopping-cart"></i> Cart</a>
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



                <!--  -->
                @if(!session('cart'))
                    <div class="container border text-center h6 py-5" id="disable-cart-msg">
                        No items in cart
                    </div>
                @endif
                


                @if(session('cart'))
                <table class="table-hover">
                <tr class="border">
                    <td class="px-4 pt-2">
                        <h6>Product Id</h6>
                    </td>
                    <td class="px-4 pt-2">    
                        <h6>Title</h6>
                    </td>
                    <td class="px-4 pt-2">    
                        <h6>Shop Name</h6>
                    </td>
                    <td class="px-4">
                        <h6>Price</h6>
                    </td>
                    <td class="px-4 pt-2">
                        <h6>Action</h6>
                    </td>
                    <td class="px-4">
                        <h6>Quantity</span></h6>
                    </td>
                    <td class="px-4">
                        <h6>Remove</span></h6>
                    </td>
                </tr>
                @for($i=0; $i<count($cartData); $i++)
                <tr class="border">
                    <td class="px-4">
                        <span> {{$cartData[$i][0]}} </apan>
                    </td>
                    <td class="px-4">    
                        <span>{{$cartData[$i][1]}}</span>
                    </td>
                    <td class="px-4">    
                        <span>{{$cartData[$i][2]}}</span>
                    </td>
                    <td class="px-4">
                        <span class="badge badge-success">{{$cartData[$i][4]}} ৳</span>
                    </td>
                    <td class="px-4 pt-2">
                    <h4 class='m-0 mb-1'><span>
                            <a href="{{route('customer.add-by-one',[$cartData[$i][0]])}}" class="text-dark"><i class="fas fa-caret-square-up"></i></a>
                            <a href="{{route('customer.reduce-by-one',[$cartData[$i][0]])}}" class="text-dark ml-3"><i class="fas fa-caret-square-down"></i></a>
                        </span>
                        </h4>
                    </td>
                    <td class="px-4">
                        <span class="badge badge-info">{{$cartData[$i][3]}}</span>
                    </td>
                    <td class="px-4">
                        <a href="{{route('customer.remove',[$cartData[$i][0]])}}" class="text-danger h3"><i class="far fa-times-circle"></i></a>
                    </td>
                </tr>
                @endfor
                
                              
                <h5 class="mb-2">Total Price:  <span class="text-danger">{{$totalPrice}} Taka</span></h5>
                </table>
                


                <form method="post">
                @csrf
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-warning btn-sm mt-3" data-toggle="modal" data-target="#exampleModal">
                    Buy Now                
                </button>
                <!-- Modal -->                
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--  -->
                        <label>Please select a shipping method:</label>
                        <div class="form-group">
                        <select name="shipping_method" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                            <option selected disabled>Shipping methods...</option>
                            <option value="Parcel shipping">Parcel shipping</option>
                            <option value="Will take from office">Will take from office</option>
                          </select>
                        </div>
                        <!--  -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                    </div>
                </div>
                </div>
                </form>
                @endif






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