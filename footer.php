<?php
// Footer.php file

include('db.php');
include('subscribe.php')
?>


<footer>
    <div class="container">
        <div class="row footer-section">
            <div class="footer-col-1">
                <div class="footer-details">
                <img src="./img/footerlogo.webp" alt="Footer Logo">
                <p style="color:white;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit corporis illo velit aperiam non id rerum repudiandae eos, ad consequuntur!</p>
                <div class="footerInformation">
                    <a href="tel:+88017777777"><i class="fa-solid fa-phone"> </i>  +88017777777</a>
                    <a href="mailto:info@roberto.com"><i class="fa-solid fa-envelope"> </i> info@roberto.com</a>
                </div>
                </div>
            </div>
            <div class="footer-col-2">
                <div class="footer-blog"></div>
            </div>
            <div class="footer-col-3">
                <div class="footer-links">
                    <h3>Essential Links</h3>
                    <ul>
                        <li><a class="" href="index.php">Home</a></li>
                        <li><a class="" href="rooms.php">Rooms</a></li>
                        <li><a class="" href="login.php">Login</a></li>
                        <li><a class="" href="register.php">Register</a></li>
                        <li><a class="" href="blog.php">News</a></li>
                        <li><a class="" href="contact.php">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-col-4">
                <div class="footer-newslatter">
                    <h3>Newsletter</h3>
                        <form action="subscribe.php" method="POST" id="newsletterForm">
                            <label for="email">Subscribe to our Newsletter:</label>
                            <input type="email" name="email" placeholder="Enter your email" required>
                            <button type="submit" name="subscribe" class="btn"><i class="fa-solid fa-paper-plane"></i> Subscribe</button>
                        </form>

                </div>
            </div>
        </div>
    </div>
</footer>
<script src="https://kit.fontawesome.com/9f68233638.js" crossorigin="anonymous"></script>