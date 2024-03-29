<!DOCTYPE html>
<!--
Template Name: Yeinydd
Author: <a href="https://www.os-templates.com/">OS Templates</a>
Author URI: https://www.os-templates.com/
Copyright: OS-Templates.com
Licence: Free to use under our free template licence terms
Licence URI: https://www.os-templates.com/template-terms
-->
<html lang="">
<!-- To declare your language - read more here: https://www.w3.org/International/questions/qa-html-language-declarations -->

 <!-- Favicons -->
 <link href="{{ asset('/yeinydd/images/demo/favicon.ico') }}" rel="icon">
 <link href="{{ asset('/arsha/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

<head>
<title>Carpio Tech</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="{{ asset('/yeinydd/layout/styles/layout.css') }}" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('{{ asset('yeinydd/images/demo/backgrounds/bg.jpg') }}');"> 
  <!-- ################################################################################################ -->
  <div class="wrapper row1">
    <header id="header" class="hoc clear"> 
      <!-- ################################################################################################ -->
      <div id="logo" class="fl_left">
        <h1><a href="/carpiotech">Carpio Tech</a></h1>
      </div>
      <!-- ################################################################################################ -->
      <nav id="mainav" class="fl_right">
        <ul class="clear">
          <li class="active"><a href="/carpiotech">Home</a></li>
          {{-- <li><a class="drop" href="#">Pages</a>
            <ul>
              <li><a href="pages/gallery.html">Gallery</a></li>
              <li><a href="pages/full-width.html">Full Width</a></li>
              <li><a href="pages/sidebar-left.html">Sidebar Left</a></li>
              <li><a href="pages/sidebar-right.html">Sidebar Right</a></li>
              <li><a href="pages/basic-grid.html">Basic Grid</a></li>
              <li><a href="pages/font-icons.html">Font Icons</a></li>
            </ul>
          </li>
          <li><a class="drop" href="#">Dropdown</a>
            <ul>
              <li><a href="#">Level 2</a></li>
              <li><a class="drop" href="#">Level 2 + Drop</a>
                <ul>
                  <li><a href="#">Level 3</a></li>
                  <li><a href="#">Level 3</a></li>
                  <li><a href="#">Level 3</a></li>
                </ul>
              </li>
              <li><a href="#">Level 2</a></li>
            </ul>
          </li> --}}
          <li><a href="#introblocks">About</a></li>
          <li><a href="#references">Portforlio</a></li>
          <li><a href="#blog">Blog</a></li>
          <li><a href="#ctdetails">Contacts</a></li>
          {{-- 
          <li><a href="#">Link Text</a></li>
          <li><a href="#">Link Text</a></li>
          <li><a href="#">Long Link Text</a></li> --}}
        </ul>
      </nav>
      <!-- ################################################################################################ -->
    </header>
  </div>
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <div id="pageintro" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <article>
      <h3 class="heading">Carpio Tech</h3>
      <p>Web Dev, Data Science Enthusiast, MIT</p>
      <footer>
        {{-- <form class="group" method="post" action="">
          <fieldset>
            <legend>Sign-Up:</legend>
            <input type="email" value="" placeholder="Email Here&hellip;">
            <button class="fas fa-sign-in-alt" type="submit" title="Submit"><em>Submit</em></button>
          </fieldset>
        </form> --}}
      </footer>
    </article>
    <!-- ################################################################################################ -->
  </div>
  <!-- ################################################################################################ -->
</div>
<!-- End Top Background Image Wrapper -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <section id="introblocks">
      <div class="sectiontitle">
        <h6 class="heading">About</h6>
        <p>This is a tutorial page where you can learn different technologies such as...</p>
      </div>
      <ul class="nospace group">
        <li class="one_quarter first">
          <article><a href="#"><i class="fas fa-code"></i></a>
            <h6 class="heading">Web Dev/Design</h6>
            <p>HTML, Bootstrap, Web Framework</p>
            {{-- <footer><a class="btn" href="#">More Details</a></footer> --}}
          </article>
        </li>
        <li class="one_quarter">
          <article><a href="#"><i class="fas fa-mobile-alt"></i></a>
            <h6 class="heading">App Dev/Design</h6>
            <p>Python, Kivy</p>
            {{-- <footer><a class="btn" href="#">More Details</a></footer> --}}
          </article>
        </li>
        <li class="one_quarter">
          <article><a href="#"><i class="fas fa-code"></i></a>
            <h6 class="heading">Machine Learning</h6>
            <p>Pandas, Sckitlearn, </p>
            {{-- <footer><a class="btn" href="#">More Details</a></footer> --}}
          </article>
        </li>
        <li class="one_quarter">
          <article><a href="#"><i class="fas fa-database"></i></a>
            <h6 class="heading">Databases</h6>
            <p>SQL, NoSQL</p>
            {{-- <footer><a class="btn" href="#">More Details</a></footer> --}}
          </article>
        </li>
      </ul>
    </section>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row2">
  <section id="references" class="hoc container clear"> 
    <!-- ################################################################################################ -->
    <div class="sectiontitle">
      <h6 class="heading">Portforlio</h6>
      {{-- <p>Eget magna eget sem imperdiet tincidunt vestibulum fringilla nulla</p> --}}
    </div>
    {{-- <nav class="ref-sort">
      <ul>
        <li class="current"><a href="#">Ultricies</a></li>
        <li><a href="#">Curabitur</a></li>
        <li><a href="#">Porttitor</a></li>
        <li><a href="#">Pulvinar</a></li>
      </ul>
    </nav> --}}
    <ul class="nospace group ref-img">
      <li class=""><a class="imgover" href=""><img src="{{ asset('yeinydd/images/demo/portforlio/pos.png') }}" alt="image here"></a></li>
      <p>POS System</p>
      
      <li class=""><a class="imgover" href=""><img src="{{ asset('yeinydd/images/demo/portforlio/clinic.png') }}" alt="image here"></a></li>
      <p>Clinic Management System</p>
      
      <li class=""><a class="imgover" href=""><img src="{{ asset('yeinydd/images/demo/portforlio/pms.png') }}" alt="image here"></a></li>
      <p>Property Management System</p>
      {{-- <li class="one_third"><a class="imgover" href="#"><img src="{{ asset('yeinydd/images/demo/348x261.png') }}" alt=""></a></li> --}}
      {{-- <li class="one_third"><a class="imgover" href="#"><img src="{{ asset('yeinydd/images/demo/348x261.png') }}" alt=""></a></li> --}}
      {{-- <li class="one_third"><a class="imgover" href="#"><img src="images/demo/348x261.png" alt=""></a></li>
      <li class="one_third"><a class="imgover" href="#"><img src="images/demo/348x261.png" alt=""></a></li>
      <li class="one_third"><a class="imgover" href="#"><img src="images/demo/348x261.png" alt=""></a></li>
      <li class="one_third"><a class="imgover" href="#"><img src="images/demo/348x261.png" alt=""></a></li>
      <li class="one_third"><a class="imgover" href="#"><img src="images/demo/348x261.png" alt=""></a></li> --}}
    </ul>
    {{-- <footer class="block center"><a class="btn" href="#">View more here</a></footer> --}}
    <!-- ################################################################################################ -->
  </section>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3">
  <section class="hoc container clear" id="blog"> 
    <!-- ################################################################################################ -->
    <div class="sectiontitle">
      <h6 class="heading">Blog</h6>
      {{-- <p>Felis vitae sapien gravida interdum curabitur eu quam nec est</p> --}}
    </div>
    <div id="latest" class="group">
      <article class="one_third first"><a class="imgover" href="#"><img src="images/demo/348x261.png" alt=""></a>
        <div class="excerpt">
          <time datetime="2045-04-03T08:15+00:00"><i class="far fa-calendar-alt"></i> 03<sup>rd</sup> April 2045 @ 15:00pm</time>
          <h6 class="heading">Aliquam volutpat donec posuere</h6>
          <ul class="meta">
            <li><i class="fas fa-user rgtspace-5"></i> <a href="#">Admin</a></li>
            <li><i class="fas fa-tags rgtspace-5"></i> <a href="#">Tag 1</a>, <a href="#">Tag 2</a></li>
          </ul>
          <p>Ornare dolor phasellus ornare dui vel euismod ultrices orci libero pulvinar justo quis condimentum quam.</p>
          <footer><a class="btn" href="#">Full Story</a></footer>
        </div>
      </article>
      <article class="one_third"><a class="imgover" href="#"><img src="images/demo/348x261.png" alt=""></a>
        <div class="excerpt">
          <time datetime="2045-04-02T08:15+00:00"><i class="far fa-calendar-alt"></i> 02<sup>nd</sup> April 2045 @ 15:00pm</time>
          <h6 class="heading">Nisl id ligula pellentesque</h6>
          <ul class="meta">
            <li><i class="fas fa-user rgtspace-5"></i> <a href="#">Admin</a></li>
            <li><i class="fas fa-tags rgtspace-5"></i> <a href="#">Tag 1</a>, <a href="#">Tag 2</a></li>
          </ul>
          <p>Felis nunc interdum vitae pretium ac bibendum vel velit phasellus commodo nullam vitae quam cras auctor.</p>
          <footer><a class="btn" href="#">Full Story</a></footer>
        </div>
      </article>
      <article class="one_third"><a class="imgover" href="#"><img src="images/demo/348x261.png" alt=""></a>
        <div class="excerpt">
          <time datetime="2045-04-01T08:15+00:00"><i class="far fa-calendar-alt"></i> 01<sup>st</sup> April 2045 @ 15:00pm</time>
          <h6 class="heading">Commodo metus proin blandit</h6>
          <ul class="meta">
            <li><i class="fas fa-user rgtspace-5"></i> <a href="#">Admin</a></li>
            <li><i class="fas fa-tags rgtspace-5"></i> <a href="#">Tag 1</a>, <a href="#">Tag 2</a></li>
          </ul>
          <p>Quam molestie luctus vehicula orci massa interdum justo nec rutrum risus augue ut nisl suspendisse elit.</p>
          <footer><a class="btn" href="#">Full Story</a></footer>
        </div>
      </article>
    </div>
    <!-- ################################################################################################ -->
  </section>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
{{-- <div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/01.png');">
  <section id="testimonials" class="hoc container clear"> 
    <!-- ################################################################################################ -->
    <div class="sectiontitle">
      <h6 class="heading">Donec condimentum</h6>
      <p>Adipiscing justo nulla mollis iaculis tortor in mauris integer</p>
    </div>
    <div class="group">
      <article class="one_half first"><img src="images/demo/80x80.png" alt="">
        <blockquote>Pretium duis viverra malesuada mi proin iaculis mauris eu sodales cursus sapien erat pharetra justo vitae volutpat eros magna et magna mauris hendrerit pellentesque.</blockquote>
        <h6 class="heading font-x1">A. Doe</h6>
        <em>Et ipsum mattis ipsum</em></article>
      <article class="one_half"><img src="images/demo/80x80.png" alt="">
        <blockquote>Pellentesque pretium proin molestie erat in rhoncus posuere nibh quam consectetuer lectus ac vulputate ligula lorem ut dolor duis tempus mauris nunc et ligula ut.</blockquote>
        <h6 class="heading font-x1">B. Doe</h6>
        <em>Tortor suscipit convallis</em></article>
    </div>
    <!-- ################################################################################################ -->
  </section>
</div> --}}
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
{{-- <div class="wrapper row3">
  <article class="hoc cta clear"> 
    <!-- ################################################################################################ -->
    <h6 class="three_quarter first">Sed ullamcorper arcu eu ante ut sollicitudin sem sit amet</h6>
    <footer class="one_quarter"><a class="btn" href="#">Ipsum fusce non pede</a></footer>
    <!-- ################################################################################################ -->
  </article>
</div> --}}
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <footer id="footer" class="hoc clear"> 
    <!-- ################################################################################################ -->
    {{-- <div class="group btmspace-80">
      <div class="one_third first">
        <h6 class="heading">Non erat varius lacinia</h6>
        <p>Morbi tincidunt in hac habitasse platea dictumst praesent pretium donec tincidunt laoreet diam nullam augue.</p>
        <p class="btmspace-30">Tortor rhoncus sed dictum vitae viverra posuere lorem pellentesque suscipit eros vel ante curabitur pretium [<a href="#"><i class="fas fa-arrow-right"></i></a>]</p>
        <ul class="faico clear">
          <li><a class="faicon-dribble" href="#"><i class="fab fa-dribbble"></i></a></li>
          <li><a class="faicon-facebook" href="#"><i class="fab fa-facebook"></i></a></li>
          <li><a class="faicon-google-plus" href="#"><i class="fab fa-google-plus-g"></i></a></li>
          <li><a class="faicon-linkedin" href="#"><i class="fab fa-linkedin"></i></a></li>
          <li><a class="faicon-twitter" href="#"><i class="fab fa-twitter"></i></a></li>
          <li><a class="faicon-vk" href="#"><i class="fab fa-vk"></i></a></li>
        </ul>
      </div>
      <div class="one_third">
        <h6 class="heading">Enim et mauris quisque vitae</h6>
        <p class="nospace btmspace-15">Libero class aptent taciti sociosqu ad litora torquent per conubia nostra.</p>
        <form method="post" action="#">
          <fieldset>
            <legend>Newsletter:</legend>
            <input class="btmspace-15" type="text" value="" placeholder="Name">
            <input class="btmspace-15" type="text" value="" placeholder="Email">
            <button type="submit" value="submit">Submit</button>
          </fieldset>
        </form>
      </div>
      <div class="one_third">
        <h6 class="heading">Per inceptos himenaeos</h6>
        <ul class="nospace clear latestimg">
          <li><a class="imgover" href="#"><img src="images/demo/100x100.png" alt=""></a></li>
          <li><a class="imgover" href="#"><img src="images/demo/100x100.png" alt=""></a></li>
          <li><a class="imgover" href="#"><img src="images/demo/100x100.png" alt=""></a></li>
          <li><a class="imgover" href="#"><img src="images/demo/100x100.png" alt=""></a></li>
          <li><a class="imgover" href="#"><img src="images/demo/100x100.png" alt=""></a></li>
          <li><a class="imgover" href="#"><img src="images/demo/100x100.png" alt=""></a></li>
        </ul>
      </div>
    </div> --}}
    <!-- ################################################################################################ -->
    <div id="ctdetails" class="clear">
      <ul class="nospace clear">
        <li class="one_quarter first">
          <div class="block clear"><a href="#"><i class="fas fa-phone"></i></a> <span><strong>Give me a call:</strong> +639 75282 6318</span></div>
        </li>
        <li class="one_quarter">
          <div class="block clear"><a href="#"><i class="fas fa-envelope"></i></a> <span><strong>Send me an mail:</strong> itscarpio@gmail.com</span></div>
        </li>
        <li class="one_quarter">
          <div class="block clear"><a href="#"><i class="fas fa-clock"></i></a> <span><strong> Everyday:</strong> 07.00am - 10.00pm</span></div>
        </li>
        <li class="one_quarter">
          <div class="block clear"><a href="#"><i class="fas fa-map-marker-alt"></i></a> <span><strong>Work from home</strong> Philippines</span></div>
        </li>
      </ul>
    </div>
    <!-- ################################################################################################ -->
  </footer>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left">Copyright &copy; 2020 - All Rights Reserved - <a href="/carpiotech">Carpio Tech</a></p>
    <p class="fl_right">Follow me  &nbsp;
        <a class="faicon-facebook" target="_blank" href="https://www.facebook.com/iamlandleybernardo"><i class="fab fa-facebook"></i></a>&nbsp;
        <a class="faicon-youtube" target="_blank" href="https://www.youtube.com/channel/UC-bjmb4m8e2Tah6FpEhQ0xw/"><i class="fab fa-youtube"></i></a>&nbsp;
        <a class="faicon-linkedin" target="_blank" href="https://www.linkedin.com/in/landley-bernardo/"><i class="fab fa-linkedin"></i></a>&nbsp;
        <a class="faicon-twitter" target="_blank" href="https://twitter.com/BernardoLandley"><i class="fab fa-twitter"></i></a>&nbsp;
        <a class="faicon-instagram"target="_blank"  href="https://www.instagram.com/carpiooooooo/"><i class="fab fa-instagram"></i></a>&nbsp;
    </p>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fas fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="{{ asset('yeinydd/layout/scripts/jquery.min.js') }}"></script>
<script src="{{ asset('yeinydd/layout/scripts/jquery.backtotop.js') }}"></script>
<script src="{{ asset('yeinydd/layout/scripts/jquery.mobilemenu.js') }}"></script>
</body>
</html>