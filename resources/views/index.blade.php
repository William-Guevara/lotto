 @extends('start')
 <!--#c62020
 #ff5821-->
 @section('content')
 <section id="carrusel" class="carrusel" style="height: 200px;text-align: center;">
     <div class="container">
         <div id="carouselExampleResult" class="carousel slide" data-ride="carousel">
             <ol class="carousel-indicators">
                 <li data-target="#carouselExampleResult" data-slide-to="0" class="active"></li>
                 <li data-target="#carouselExampleResult" data-slide-to="1"></li>
                 <li data-target="#carouselExampleResult" data-slide-to="2"></li>
                 <li data-target="#carouselExampleResult" data-slide-to="3"></li>
                 <li data-target="#carouselExampleResult" data-slide-to="4"></li>
                 <li data-target="#carouselExampleResult" data-slide-to="5"></li>
                 <li data-target="#carouselExampleResult" data-slide-to="6"></li>
             </ol>
             <div class="carousel-inner">
                 <div class="carousel-item active">
                     <h1 class="title" style="color:red;">{!! $results[0]->category !!}</h1>
                     <p>{!! $results[0]->drawing_date !!}</p>
                     <h3 class="description" style="color:green;">{!! $results[0]->numbers !!}</h3>
                 </div>
                 <div class="carousel-item">
                     <h1 class="title" style="color:red;">{!! $results[1]->category !!}</h1>
                     <p>{!! $results[1]->drawing_date !!}</p>
                     <h3 class="description" style="color:green;">{!! $results[1]->numbers !!}</h3>
                 </div>
                 <div class="carousel-item">
                     <h1 class="title" style="color:red;">{!! $results[2]->category !!}</h1>
                     <p>{!! $results[2]->drawing_date !!}</p>
                     <h3 class="description" style="color:green;">{!! $results[2]->numbers !!} {!!
                         $results[2]->drawing_date !!}</h3>
                 </div>
                 <div class="carousel-item">
                     <h1 class="title" style="color:red;">{!! $results[3]->category !!}</h1>
                     <p>{!! $results[3]->drawing_date !!}</p>
                     <h3 class="description" style="color:green;">{!! $results[3]->numbers !!}</h3>
                 </div>
                 <div class="carousel-item">
                     <h1 class="title" style="color:red;">{!! $results[4]->category !!}</h1>
                     <p>{!! $results[4]->drawing_date !!}</p>
                     <h3 class="description" style="color:green;">{!! $results[4]->numbers !!}</h3>
                 </div>
                 <div class="carousel-item">
                     <h1 class="title" style="color:red;">{!! $results[5]->category !!}</h1>
                     <p>{!! $results[5]->drawing_date !!}</p>
                     <h3 class="description" style="color:green;">{!! $results[5]->numbers !!}</h3>
                 </div>
                 <div class="carousel-item">
                     <h1 class="title" style="color:red;">{!! $results[6]->category !!}</h1>
                     <p>{!! $results[6]->drawing_date !!}</p>
                     <h3 class="description" style="color:green;">{!! $results[6]->numbers !!}</h3>
                 </div>
             </div>
             <a class="carousel-control-prev" href="#carouselExampleResult" role="button" data-slide="prev">
                 <span class="carousel-control-prev-icon" style="background-color:black; border-radius: 10px 10px"
                     aria-hidden="true"></span>
                 <span class="sr-only">Previous</span>
             </a>
             <a class="carousel-control-next" href="#carouselExampleResult" role="button" data-slide="next">
                 <span class="carousel-control-next-icon" style="background-color:black; border-radius: 10px 10px"
                     aria-hidden="true"></span>
                 <span class="sr-only">Next</span>
             </a>
         </div>
     </div>
 </section>

 <section id="carrusel" class="carrusel section-bg">
     <div class="container">
         <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
             <ol class="carousel-indicators">
                 <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                 <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                 <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
             </ol>
             <div class="carousel-inner">
                 <div class="carousel-item active">
                     <img class="d-block w-100" src="{{ asset('images/slider-03.png') }}" alt="First slide">
                 </div>
                 <div class="carousel-item">
                     <img class="d-block w-100" src="{{ asset('images/slider-07.png') }}" alt="Second slide">
                 </div>
                 <div class="carousel-item">
                     <img class="d-block w-100" src="{{ asset('images/slider-10.png') }}" alt="Third slide">
                 </div>
             </div>
             <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                 <span class="sr-only">Previous</span>
             </a>
             <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                 <span class="carousel-control-next-icon" aria-hidden="true"></span>
                 <span class="sr-only">Next</span>
             </a>
         </div>
     </div>
 </section>
 {{-- ======= About Section ======= --}}
 <section id="about" class="about">
     <div class="container">

         <div class="row">

             <div class="col-12 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                 <h3 data-aos="fade-up">{!! trans('messages.about') !!}</h3>
                 <div class="row">
                     <div class="col-6 icon-box" data-aos="fade-up">
                         <div class="icon"><i class="bx bxs-store-alt"></i></div>
                         <h4 class="title"><a href="">{!! trans('messages.buyTicket') !!}</a></h4>
                         <p class="description">{!! trans('messages.buyTicket1') !!}</p>
                     </div>

                     <div class="col-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                         <div class="icon"><i class="bx bx-gift"></i></div>
                         <h4 class="title"><a href="">{!! trans('messages.process') !!}</a></h4>
                         <p class="description">{!! trans('messages.process1') !!}</p>
                     </div>

                     <div class="col-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                         <div class="icon"><i class="bx bx-atom"></i></div>
                         <h4 class="title"><a href="">{!! trans('messages.security') !!}</a></h4>
                         <p class="description">{!! trans('messages.security1') !!}</p>
                     </div>
                     <div class="col-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                         <div class="icon"><i class="bx bx-gift"></i></div>
                         <h4 class="title"><a href="">{!! trans('messages.legality') !!}</a></h4>
                         <p class="description">{!! trans('messages.legality1') !!}</p>
                     </div>

                     <div class="col-12 icon-box" data-aos="fade-up" data-aos-delay="200">
                         <div class="icon"><i class="bx bx-atom"></i></div>
                         <h4 class="title"><a href="">{!! trans('messages.company') !!}</a></h4>
                         <p class="description">{!! trans('messages.company1') !!}</p>
                     </div>

                 </div>
             </div>
         </div>

     </div>
 </section>
 <div class="section-bg"></div>
 {{-- ======= F.A.Q Section ======= --}}
 <section id="faq" class="faq section-bg">
     <div class="container">

         <div class="section-title">
             <h2 data-aos="fade-up">{!! trans('messages.faq') !!}</h2>
         </div>

         <div class="faq-list">
             <ul>
                 <li data-aos="fade-up">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" class="collapse"
                         href="#faq-list-1">{!! trans('messages.isLegal') !!}<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-1" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.isLegal1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="100">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-2"
                         class="collapsed">{!! trans('messages.howWill') !!}<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-2" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.howWill1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="200">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-3"
                         class="collapsed">{!! trans('messages.howDo') !!}<i class="bx bx-chevron-down icon-show"></i><i
                             class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-3" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.howDo1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="300">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-4"
                         class="collapsed">{!! trans('messages.canYou') !!}<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-4" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.canYou1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-5"
                         class="collapsed">{!! trans('messages.doYouSell') !!}<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-5" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.doYouSell1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-6"
                         class="collapsed">{!! trans('messages.doI') !!}<i class="bx bx-chevron-down icon-show"></i><i
                             class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-6" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.doI1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-7"
                         class="collapsed">{!! trans('messages.canI') !!}<i class="bx bx-chevron-down icon-show"></i><i
                             class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-7" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.canI1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-8"
                         class="collapsed">{!! trans('messages.isYour') !!}<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-8" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.isYour1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-9"
                         class="collapsed">{!! trans('messages.whenAre') !!}<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-9" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.whenAre1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-10"
                         class="collapsed">{!! trans('messages.whenWill') !!}<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-10" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.whenWill1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-11"
                         class="collapsed">{!! trans('messages.doesYour') !!}<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-11" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.doesYour1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-12"
                         class="collapsed">{!! trans('messages.howIsMy') !!}<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-12" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.howIsMy1') !!}
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-13"
                         class="collapsed">{!! trans('messages.whatHappens') !!}<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-13" class="collapse" data-parent=".faq-list">
                         <p>
                             {!! trans('messages.whatHappens1') !!}
                         </p>
                     </div>
                 </li>

             </ul>
         </div>

     </div>
 </section>
 {{-- ======= Contact Section ======= --}}
 <section id="contact" class="contact">
     <div class="container">

         <div class="section-title">
             <h2 data-aos="fade-up">{!! trans('messages.contact') !!}</h2>
             <p data-aos="fade-up">{!! trans('messages.contact1') !!}</p>
         </div>

         <div class="row justify-content-center">

             <div class="col-xl-4 col-lg-4 mt-4" data-aos="fade-up">
                 <div class="info-box">
                     <i class="bx bx-map"></i>
                     <h3>{!! trans('messages.ourAddress') !!}</h3>
                     <p>21050 NE 38 Ave. Suite 3004<br> Aventura, Fl 33180</p>
                 </div>
             </div>

             <div class="col-xl-4 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="100">
                 <div class="info-box">
                     <i class="bx bx-envelope"></i>
                     <h3>{!! trans('messages.emailUs') !!}</h3>
                     <p>info@loteriasmillonarias.com</p>
                 </div>
             </div>
             <div class="col-xl-4 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="200">
                 <div class="info-box">
                     <i class="bx bx-phone-call"></i>
                     <h3>{!! trans('messages.callUs') !!}</h3>
                     <p>+1 786-436-7676</p>
                 </div>
             </div>
         </div>

         <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
             <div class="col-xl-9 col-lg-12 mt-4">
                 <div class="php-email-form">
                     <div class="form-row">
                         <div class="col-md-6 form-group">
                             <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                                 data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                             <div class="validate"></div>
                         </div>
                         <div class="col-md-6 form-group">
                             <input type="email" class="form-control" name="email" id="email" placeholder="Your Email"
                                 data-rule="email" data-msg="Please enter a valid email" />
                             <div class="validate"></div>
                         </div>
                     </div>
                     <div class="form-group">
                         <textarea class="form-control" name="comments" id="comments" rows="5" data-rule="required"
                             data-msg="Please write something for us" placeholder="comments"></textarea>
                         <div class="validate"></div>
                     </div>
                     <div class="text-center">
                         <button id="btn_send_contact" type="input" class="btn btn-lg btn-danger">{!!
                             trans('messages.sendMessage') !!}</button>
                     </div>
                 </div>
             </div>

         </div>

     </div>
 </section>
 {{--Fin contenido pagina principal--}}
 @endsection

 @section('scripts')
 <!--<script src="{{ asset('js/function_js.js') }}"></script>-->
 <script src="{{ asset('js/js_blade/contact.js') }}"></script>

 <script>
function getAddContact() {
    var url = "{{ route('addMenssage') }}";
    return url;
}
 </script>

 @endsection