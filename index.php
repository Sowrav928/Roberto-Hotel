<?php

include('db.php');
include('font.php');
include('header.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Roberto - Hotel & Restourant</title>
</head>
<body>

    <section class="heroSlider">
        <div class="container-fluid">
                <div class="slider">
                    <div class="slides">
                        <div class="slide">
                            <img src="./img/Slide1.jpg" alt="Slide 1">
                            <div class="content">
                                <div class="contentWrap">
                                    <p>The Best Hotel & Resort</p>
                                    <h2>Welcome To Roberto</h2>
                                    <div class="btnGroup">
                                        <a href="./contact.php" class="btn">Contact Us</a>
                                        <a href="#aboutUs" class="btn">Know More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide">
                            <img src="./img/Slide2.jpg" alt="Slide 2">
                            <div class="content">
                                <div class="contentWrap">
                                    <p>The Best Hotel & Resort</p>
                                    <h2>Welcome To Roberto</h2>
                                    <div class="btnGroup">
                                        <a href="./contact.php" class="btn">Contact Us</a>
                                        <a href="#aboutUs" class="btn">Know More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide">
                            <img src="./img/Slide3.jpg" alt="Slide 3">
                            <div class="content">
                                <div class="contentWrap">
                                    <p>The Best Hotel & Resort</p>
                                    <h2>Welcome To Roberto</h2>
                                    <div class="btnGroup">
                                        <a href="./contact.php" class="btn">Contact Us</a>
                                        <a href="#aboutUs" class="btn">Know More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="prev" onclick="prevSlide()">❮</button>
                    <button class="next" onclick="nextSlide()">❯</button>
                </div>
        </div>
    </section>

    <section class="aboutUs" id="aboutUs">
        <div class="container">
            <div class="auWrapper row">
                <div class="auLeft">
                    <h5 class="auTITLE">About Us</h5>
                    <h3 class="auHeading">Welcome to Roberto Hotel Luxury</h3>
                    <p class="auContent">Nestled in the heart of Maldives, Roberto offers a perfect blend of elegance and convenience. With breathtaking views, thoughtfully designed spaces, and personalized service, we are dedicated to making every moment of your stay exceptional. From cozy rooms to luxurious suites, your comfort is our priority.</p>
                </div>
                <div class="auRight">
                    <img src="./img/au3.webp" class="auimg1" alt="">
                </div>
            </div>
        </div>
    </section>

    <section class="feature">
        <div class="container">
            <div class="featureWrapper row">
                <div class="featureItem">
                    <div class="fIcon"><img src="./img/steering-wheel.png" alt="Transportion"></div>
                    <h4>Transportion</h4>
                </div>
                <div class="featureItem">
                    <div class="fIcon"><img src="./img/customer-service.png" alt="Reiseservice"></div>
                    <h4>Reiseservice</h4>
                </div>
                <div class="featureItem">
                    <div class="fIcon"><img src="./img/restuarant.png" alt="Resturant"></div>
                    <h4>Resturant</h4>
                </div>
                <div class="featureItem">
                    <div class="fIcon"><img src="./img/massage.png" alt="Spa"></i></div>
                    <h4>Spa</h4>
                </div>
                <div class="featureItem">
                    <div class="fIcon"><img src="./img/cheers.png" alt="Bar"></div>
                    <h4>Bar</h4>
                </div>
            </div>
        </div>
    </section>

    <section class="entertainment">
        <div class="container-fluid">
            <div class="entWrapper row">
                <div class="entItem entItem1 ">
                    <div class="headingButtom">
                        <h4>Entertainment</h4>
                        <h3>Sea Swimming</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos doloremque inventore odio error alias facere doloribus libero esse, laborum adipisci reprehenderit repellendus cupiditate natus tenetur aut dignissimos ipsa illum debitis. Voluptates at laborum incidunt commodi impedit. Pariatur et optio dolorem.</p>
                    </div>
                </div>
                <div class="entItem  entItem2">
                    <div class="headingButtom">
                        <h4>Entertainment</h4>
                        <h3>Sea Swimming</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos doloremque inventore odio error alias facere doloribus libero esse, laborum adipisci reprehenderit repellendus cupiditate natus tenetur aut dignissimos ipsa illum debitis. Voluptates at laborum incidunt commodi impedit. Pariatur et optio dolorem.</p>
                    </div>
                </div>
                <div class="entItem entItem3 ">
                    <div class="headingButtom">
                        <h4>Entertainment</h4>
                        <h3>Sea Swimming</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos doloremque inventore odio error alias facere doloribus libero esse, laborum adipisci reprehenderit repellendus cupiditate natus tenetur aut dignissimos ipsa illum debitis. Voluptates at laborum incidunt commodi impedit. Pariatur et optio dolorem.</p>
                    </div>
                </div>
                <div class="entItem entItem4">
                    <div class="headingButtom">
                        <h4>Entertainment</h4>
                        <h3>Sea Swimming</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos doloremque inventore odio error alias facere doloribus libero esse, laborum adipisci reprehenderit repellendus cupiditate natus tenetur aut dignissimos ipsa illum debitis. Voluptates at laborum incidunt commodi impedit. Pariatur et optio dolorem.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonial">
        <div class="container">
            <div class="testimonialWrapper row">
                <div class="tmImg" style="text-align:right">
                    <img src="./img/person.webp" alt="">
                </div>
                <div class="tmCon">
                    <h5>Testimonial</h5>
                    <h3 class="auHeading">Our Guests Love Us</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus voluptates, velit nobis ratione voluptas maxime! Esse architecto velit quae autem veniam aliquid. Nemo quis magnam minus reprehenderit veniam sed vero.</p>
                    <h6>-- John Deo</h6>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="container">
            <div class="ctaWrapper row">
                <div class="ctaWrapperLeft">
                    <h5>Let's Make Your Stay Perfect</h5>
                    <h3>We're here to assist you 24/7.</h3>
                    <p>Have questions or special requests? Our team is dedicated to ensuring your stay is seamless and memorable. Feel free to reach out for bookings, event inquiries, or any other assistance you may need.</p>
                </div>
                <div class="ctaWrapperRight">
                    <a href="./contact.php" class="btn btn-white"><i class="fa-solid fa-paper-plane"></i> Contact</a>
                </div>
            </div>
        </div>
    </section>


    <script src="./slider.js"></script>
    
</body>
</html>

<?php include('footer.php')  ?> 


