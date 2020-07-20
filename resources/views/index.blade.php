 @extends('start')
 <!--#c62020
 #ff5821-->
 @section('content')

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
                     <h1>Mega millons</h1>
                     <img class="d-block w-100" src="{{ asset('images/slider-02.jpg') }}" alt="First slide">
                 </div>
                 <div class="carousel-item">
                     <img class="d-block w-100" src="{{ asset('images/slider-09.png') }}" alt="Second slide">
                 </div>
                 <div class="carousel-item">
                     <img class="d-block w-100" src="{{ asset('images/slider-09.png') }}" alt="Third slide">
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
                 <h3 data-aos="fade-up">How does it work?</h3>
                 <div class="row">
                     <div class="col-6 icon-box" data-aos="fade-up">
                         <div class="icon"><i class="bx bxs-store-alt"></i></div>
                         <h4 class="title"><a href="">Buy ticket</a></h4>
                         <p class="description">1- We buy for you a random Lotto ticket also known as Quick Pick of
                             the selected
                             Lotteries. We will personalize the ticket with your name ensuring your property. You
                             and
                             only you can cash your price.</p>
                     </div>

                     <div class="col-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                         <div class="icon"><i class="bx bx-gift"></i></div>
                         <h4 class="title"><a href="">Process</a></h4>
                         <p class="description">2- We proceed to scan and make and electronic image of your ticket,
                             front and back, we will email it to you before each game (you will have it as prove of
                             ownership). </p>
                     </div>

                     <div class="col-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                         <div class="icon"><i class="bx bx-atom"></i></div>
                         <h4 class="title"><a href="">Security</a></h4>
                         <p class="description">3- We properly identify the Ticket and archive it in a security box
                         </p>
                     </div>
                     <div class="col-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                         <div class="icon"><i class="bx bx-gift"></i></div>
                         <h4 class="title"><a href="">Legality</a></h4>
                         <p class="description">4- Our Messenger services can be contracted in periods of Three, Six
                             and Twelve Month respectively. Doing so you ensure your timely participation </p>
                     </div>

                     <div class="col-12 icon-box" data-aos="fade-up" data-aos-delay="200">
                         <div class="icon"><i class="bx bx-atom"></i></div>
                         <h4 class="title"><a href="">Company</a></h4>
                         <p class="description">5- LoteriasMillonarias.com constantly checks the tickets and inform
                             via email and/or phone of any associated price so you will decide the way you will like
                             to receive and enjoy it. We invite you to Review our Frequent asked questions in case
                             of any doubt please contact us</p>
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
             <h2 data-aos="fade-up">F.A.Q</h2>
         </div>

         <div class="faq-list">
             <ul>
                 <li data-aos="fade-up">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" class="collapse"
                         href="#faq-list-1">IS THIS SERVICE LEGAL? <i class="bx bx-chevron-down icon-show"></i><i
                             class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-1" class="collapse" data-parent=".faq-list">
                         <p>
                             Yes. The activity of our company is a simple legal activity of messenger services of
                             high quality and responsibility; which is authorized and requested by you, when you
                             subscribe to the service. We will buy for you the requested lottery ticket, during the
                             contracted period, will keep it in a safe-deposit box and will send via email a scan of
                             your ticket marked with your name on it; this will be the proof of purchase of your
                             ticket, following your instructions. This activity is supported by the infrastructure
                             of direct marketing and messenger services of United Messenger Services LLC; Company
                             registered under the law of the State Of Florida in the United States.
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="100">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-2"
                         class="collapsed">HOW WILL I FIND OUT THAT I HAVE WON A PRIZE ?<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-2" class="collapse" data-parent=".faq-list">
                         <p>
                             It is included in our service the revision of 100% of the tickets bought for our users,
                             including an email that is sent to the registered email address advising the client
                             with the prize won, no matter what amount it is. However it is each client?s
                             responsibility to check his ticket after each draw. In addition to this, the results of
                             the various lotteries are uploaded in our Web page, so that you can verify by yourself
                             the results; or you can always visit the official sites of the different lotteries if
                             that is your preference.
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="200">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-3"
                         class="collapsed">HOW DO I CLAIM MY PRIZE IN THE EVENT THAT I AM A WINNER?<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-3" class="collapse" data-parent=".faq-list">
                         <p>
                             A winning ticket prize of up to USS600.00 could be cashed using our same messenger
                             services at any official retail store, and could be sent to you in a check written to
                             your name, we will only deduct the shipping costs. For prizes of USS600.00 or more, our
                             service will personally give the winning ticket to you in our offices, for it to be
                             cashed in person, if you are unable to be present in our offices, we will send your
                             ticket via express or certified mail, or using a high value transportation company,
                             when it comes to considerable amounts of money; all charges related to how we send the
                             ticket to you will be at your own expense and risk. All this with the purpose of you
                             cashing your prize in some other time within the time frame that each of the lotteries
                             give for claiming prizes, or to do it by mail, which is also an option that the
                             lotteries have to claim prizes.
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="300">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-4"
                         class="collapsed">CAN YOU CASH A PRIZE FOR ME IN THE EVENT THAT I HAVE A WINNING TICKET?<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-4" class="collapse" data-parent=".faq-list">
                         <p>
                             The ticket is marked with your name before each of the drawings, which gives you
                             immediate property over your ticket, eliminating any chance to ?steal? or for third
                             parties to claim your prize. It is important to bear in mind that the different
                             lotteries pay prizes of up to US$600.00 at the official retail stores, which makes it
                             easier when cashing low amount prizes. For prizes over US$600.00, we will personally
                             give the ticket to the owner at our offices; we also offer options to our clients when
                             unable to be present when claiming a prize (see FAQ # 3).
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-5"
                         class="collapsed">DO YOU SELL LOTTERY ?<i class="bx bx-chevron-down icon-show"></i><i
                             class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-5" class="collapse" data-parent=".faq-list">
                         <p>
                             No. Our Company does not support its commercial activities in selling lottery tickets,
                             and it has no direct or indirect relationship with the official state lotteries
                             whatsoever; our service is a responsible messenger service, which by your instructions,
                             will buy for you the lottery tickets requested. Our Company does not participate or get
                             commissions for any lottery prize; we are limited to offering you a professional,
                             friendly and honest messenger service.
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-6"
                         class="collapsed">DO I HAVE TO PAY TAXES IN THE EVENT THAT I WIN A PRIZE?<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-6" class="collapse" data-parent=".faq-list">
                         <p>
                             Yes, any US resident or foreign national must pay taxes according to each of the
                             States? law, when it comes to lottery prizes and occasional wins for prizes over
                             US$600.00. The percentage withheld varies in each State. These taxes are deducted most
                             of the times when claiming the prize.
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-7"
                         class="collapsed">CAN I BUY LOTTERY EVEN IF I AM NOT A US CITIZEN OR RESIDENT? <i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-7" class="collapse" data-parent=".faq-list">
                         <p>
                             Yes, any foreign national 18 years or older may buy lottery tickets in the United
                             States.
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-8"
                         class="collapsed">IS YOUR COMPANY REPONSIBLE FOR PAYING A LOTTERY PRIZE ?<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-8" class="collapse" data-parent=".faq-list">
                         <p>
                             No. Our company has no direct or indirect relationship with any of the lotteries for
                             which we offer the service, ours is simply a messenger service where we buy for you the
                             tickets, therefore our company will always give you any winning ticket of US$600.00 and
                             over, in order for you to personally claim the prize, we are not responsible for any
                             prize. The responsibility of paying a prize is solely on the lottery entity selling the
                             ticket.
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-9"
                         class="collapsed">WHEN ARE THE DRAWINGS HELD?<i class="bx bx-chevron-down icon-show"></i><i
                             class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-9" class="collapse" data-parent=".faq-list">
                         <p>
                             Lottery drawings offered by our service are held as follows:
                             - Florida: twice a week, on Wednesdays and Saturdays at 11pm EST (Eastern Standard
                             Time).

                             - New York: twice a week, on Wednesdays and Saturdays at 11:21pm EST (Eastern Standard
                             Time).

                             - Power Ball: twice a week, on Wednesdays and Saturdays at 10:59pm EST (Eastern
                             Standard Time).

                             - Mega Millions: twice a week, on Tuesdays and Fridays at 11pm EST (Eastern Standard
                             Time).

                             - Texas: twice a week, on Wednesdays and Saturdays at 10pm EST (Center Standard Time).
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-10"
                         class="collapsed">WHEN WILL MY SUBSCRIPTION TO THE SERVICE BE ACTIVATED?<i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-10" class="collapse" data-parent=".faq-list">
                         <p>
                             Your subscription will be activated as soon as possible, trying to include your name in
                             the
                             very next draw, allowing you to start playing right away. We will advise you via email
                             about
                             the activation of your subscription; once you receive your invoice you are included in
                             the next
                             draw, unless other wise advised.
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-11"
                         class="collapsed">DOES YOUR COMPANY EARN MONEY IN ANY PERCETAE OVER MY WINNING TICKET? <i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-11" class="collapse" data-parent=".faq-list">
                         <p>
                             No. Our company does not participate in any lottery winning prize, and is not
                             responsible for
                             prizes at all, ours is simply a messenger service activity, and therefore we will not
                             charge
                             any percentage over any prize won by any of our clients.
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-12"
                         class="collapsed">HOW IS MY SUBSCRIPTION TO THE MESSENGER SERVICES SUPPORT AND WHAT IS THE
                         PROCEDURE?<i class="bx bx-chevron-down icon-show"></i><i
                             class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-12" class="collapse" data-parent=".faq-list">
                         <p>
                             Once you subscribe to our messenger service, you will be doing it through a properly
                             established company, registered under the Florida State law. You will be receiving an
                             email
                             with the confirmation of your payment, approved by our company and supported by the
                             financial
                             entity issuing your credit card. Once the payment is done, you will receive the
                             commercial
                             invoice, confirming your subscription to our service and the approval of your
                             transaction; and
                             last you will start receiving emails with a scanned copy of your ticket marked with
                             your name,
                             this will happen twice a week before each of the drawings and during the contracted
                             period.
                         </p>
                     </div>
                 </li>

                 <li data-aos="fade-up" data-aos-delay="400">
                     <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-13"
                         class="collapsed">WHAT HAPPENS IF I DO NOT RECEIVE MY TICKET ? <i
                             class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                     <div id="faq-list-13" class="collapse" data-parent=".faq-list">
                         <p>
                             Once you subscribe to our service, we will provide you with your login and password for
                             you to
                             access our web page where you can see your ticket any time before or after a draw. This
                             in
                             order to prevent when you do not receive your ticket via email, due to world wide web
                             being
                             overcharged or problems with your email account. If this happens regularly contact us
                             and let
                             us know about the problem, we can always resend the emails with your tickets, or you
                             can
                             provide us with another email address for future reference.
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
             <h2 data-aos="fade-up">Contact</h2>
             <p data-aos="fade-up">Would you have any questions please call or e-mail us</p>
         </div>

         <div class="row justify-content-center">

             <div class="col-xl-4 col-lg-4 mt-4" data-aos="fade-up">
                 <div class="info-box">
                     <i class="bx bx-map"></i>
                     <h3>Our Address</h3>
                     <p>21050 NE 38 Ave. Suite 3004<br> Aventura, Fl 33180</p>
                 </div>
             </div>

             <div class="col-xl-4 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="100">
                 <div class="info-box">
                     <i class="bx bx-envelope"></i>
                     <h3>Email Us</h3>
                     <p>info@loteriasmillonarias.com</p>
                 </div>
             </div>
             <div class="col-xl-4 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="200">
                 <div class="info-box">
                     <i class="bx bx-phone-call"></i>
                     <h3>Call Us</h3>
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
                         <textarea class="form-control" name="comments" rows="5" data-rule="required"
                             data-msg="Please write something for us" placeholder="comments"></textarea>
                         <div class="validate"></div>
                     </div>
                     <div id="btn_send" class="btn_send text-center"><button type="submit">Send Message</button>
                     </div>
                 </div>
             </div>

         </div>

     </div>
 </section>
 <div class="section-bg"></div>
 {{--Fin contenido pagina principal--}}
 @endsection

 @section('scripts')
 <script src="{{ asset('js/function_js.js') }}"></script>
 @endsection