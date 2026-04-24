<!doctype html>
<html lang="en">
<head>
    @include('includes.header_links')

    <title>Contact Al Sajjad Production | Get in Touch with Us</title>
    <meta name="description" content="Contact Al Sajjad Production for inquiries about our high-quality leather products, including bags, wallets, and accessories."/>
    <meta name="keywords" content="Contact Al Sajjad Production, leather product inquiries, leather manufacturing, customer support, leather bags, leather wallets, leather accessories"/>
</head>

<body>


  <!-- Navbar Start -->
  @include('includes.navbar')
  <!-- Navbar End -->




  <div class="inner-banner">
    <div class="container">
        <div class="inner-title text-center">
            <h3>Contact Us</h3>
            <ul>
                <li>
                    <a href="/">Home</a>
                </li>
                <li>
                    <i class="bx bx-chevrons-right"></i>
                </li>
                <li>Contact Us</li>
            </ul>
        </div>
    </div>
    
</div>


<div class="contact-form-area pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <h2>Let's Send Us a Message Below</h2>
        </div>
        <div class="row pt-45">
            <div class="col-lg-4">
                <div class="contact-info mr-20">
                    <span>Contact Info</span>
                    <h2>Let's Connect With Us</h2>
                    <p>We specializes in marketing and distribution of leather products </p>
                    <ul>
                        <li>
                            <div class="content">
                                <i class="bx bx-phone-call"></i>
                                <h3>Phone Number</h3>
                                <a href="tel:+923467454565">+92 346 7454 565</a>
                            </div>
                        </li>
                        <li>
                            <div class="content">
                                <i class="bx bxs-map"></i>
                                <h3>Address</h3>
                                <span>Main Kasso ki Road, Hafizabad, Punjab, Pakistan</span>
                            </div>
                        </li>
                        <li>
                            <div class="content">
                                <i class="bx bx-message"></i>
                                <h3>Email</h3>
                                <a href="mailto:info@alsajjadproduction.com">info@alsajjadproduction.com</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="contact-form">
                    @include('includes.success')
                    <form method="post" action="/contactUs">
                       <form method="post" action="/contactUs">
                          @csrf
                          <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Your Name <span>*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" required="" data-error="Please Enter Your Name" placeholder="Name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Your Email <span>*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" required="" data-error="Please Enter Your Email" placeholder="Email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Phone Number <span>*</span></label>
                                    <input type="text" name="phone" id="phone_number" required="" data-error="Please Enter Your number" class="form-control" placeholder="Phone Number">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Your Subject <span>*</span></label>
                                    <input type="text" name="subject" id="msg_subject" class="form-control" required="" data-error="Please Enter Your Subject" placeholder="Your Subject">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label>Your Message <span>*</span></label>
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="8" required="" data-error="Write your message" placeholder="Your Message"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12 col-md-12 text-center">
                                <button type="submit" class="default-btn btn-bg-two border-radius-50">
                                    Send Message <i class="bx bx-chevron-right"></i>
                                </button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




@include('includes.footer')

@include('includes.footer_links')
</body>
</html>
