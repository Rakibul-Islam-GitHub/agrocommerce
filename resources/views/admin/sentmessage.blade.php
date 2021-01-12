<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Agro-Commers</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="/abc/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="{{route('admin.index')}}">Agro-Commers</a>
                <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars m-0 p-0 mx-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a href="#" class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"><i class="fa fa-user mr-1 pr-1" aria-hidden="true"></i>{{ Session::get('user')->name }}</a></li>
                    </ul>
                </div>
            </div>
        </nav>
               <!-- Body Section-->
        <section class="page-section portfolio" id="portfolio">
            <div class="container">
                <br>
                <br>
                <form method="post" action="">
                @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Send:</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" aria-describedby="emailHelp" name="send" value="a@gmail.com">
                        <small id="emailHelp" class="form-text text-muted"></small>
                        @error('sender_email')	
								<span style="color: red">*{{ $message }}</span><br><br>
						@enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleInputUsername1">To:</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" aria-describedby="emailHelp" name="to" value="">
                        <small id="emailHelp" class="form-text text-muted"></small>
                        @error('receiver_email')	
								<span style="color: red">*{{ $message }}</span><br><br>
						@enderror
                      </div>
                      <div class="form-group">
                        <textarea id="w3review" name="mess" placeholder="write message" rows="4" cols="40">
                        </textarea>
                        @error('message')	
								<span style="color: red">*{{ $message }}</span><br><br>
						@enderror
                      </div>
                    <button type="submit" class="btn btn-primary">Send</button>

                    @if (Session::has('re-msg'))
							<br><br>
							<div>
								<span class="alert alert-danger" style="margin-left: 9%">{{ session('re-msg') }}</span>
							</div>
					@endif
                  </form>
                <!-- ---------------Body start---------------- -->


                <!-- ---------------Body End---------------- -->
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
                            We sell all types of agricultural products
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
        <script src="/abc/js/scripts.js"></script>
    </body>
</html>
