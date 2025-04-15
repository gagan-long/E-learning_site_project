<?php
session_start();
$title = "Welcome to LearnToCode";
// include_once 'includes/header_user.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
  <title>LEARNTOCODE</title>
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="resouurces/css/styles.css">
  <style>
  nav {
    background-color: transparent;
    backdrop-filter: blur(3px);
    position: fixed;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100vw;
    height: 75px;
    padding: 14px 70px 7px;
    z-index: 1999;
}

#nav_left {
    height: 30px;
    width: 20vw;
    display: flex;
    align-items: center;
}

#nav_left a {
    text-decoration: none;
    font-size: 2.5rem;
    color: #27E0B3;
}

.nav_right {
    height: 30px;
    display: flex;
    align-items: center;
    gap: 2.4vw;
    font-weight: 500;
}

.nav_right > a {
    text-decoration: none;
    transition: all ease 0.20s;
}

.nav_right > a:hover {
    color: #27E0B3;
    text-decoration: underline;
}

/* Mobile Styles */
#mobile_menu {
    display: none; /* Hidden by default */
    font-size: 2.5rem; /* Adjust size as needed */
}

/* Media Query for Mobile Devices */
@media (max-width: 768px) {
    body{
      overflow-x: hidden;
    }
    .nav_right {
        display: none; /* Hide nav links by default */
        flex-direction: column; /* Stack links vertically */
        position: absolute; /* Position it absolutely */
        top: 75px; /* Below the navbar */
        left: 0; 
        right: 0; 
        background-color: rgba(255, 255, 255, 0.9); /* Background for visibility */
        padding: 10px; /* Padding for links */
        box-shadow: 0px 4px 10px rgba(0,0,0,0.1); /* Optional shadow */
        z-index: 1000; /* Ensure it appears above other content */
    }

    #mobile_menu {
        display: block; /* Show the mobile menu icon */
        cursor: pointer; /* Pointer cursor for interaction */
    }

    .nav_right.active {
        display: flex; /* Show nav links when active */
        background-color: black;
    }
    #nav_left a{
      font-size: 1.4rem;
    }
    #nav_left {
      
    
    width: 40vw;
    
    }
    main{
      height: 100dvh;
      width: 100dvw;
      overflow-x: hidden;
    }
    .top{
      height: 2dvh;
    }
    .center h1{
      font-size: 2.7rem;
    }
    
    .page1 button{
      margin-top: 2dvh;
      font-size: 4.5vw;
    }
    .achivement>h2{
      font-size: 5dvw;
    }
    .achivement>p{
      font-size: 4vw;
    }
    .page2{
      margin-top: 4dvh;
    }

    #features-ditails{
      flex-direction: column;
    }
    #features-ditails i{
      font-size: 1.5rem;
    }
    .features1 h3{
    font-size: 1.5rem;
    }

  .features1{
  margin-top: 4dvh;
  width: 100dvw;
  }

  /* ------------------- page 3---------------- */
  .page3{
    flex-direction: column;
    margin-top: 3dvh;
    margin-bottom: 20dvh;
  }
  #page3-left{
    margin-top: 5dvh;
    width: 100dvw;
   
  }
  .page3-poster{
    width: 35dvw;
    /* height: ; */
  }

  #page3-right{

    width: 100dvw;
    text-align: center;
    padding: 0 ;
  }
  #page3-right h1{
    font-size: 1.3rem;
    width: 100dvw;
  }
  #page3-right h3{
    font-size: 0.9;
  }
  #more-btn{
    /* height: 0; */
    margin: 0;
    padding: 0 20dvw 0 10dvw;
    float: none;
    margin-bottom: 5dvh;
  }

  /* ---------------- page 6-------------- */
  .page6{
    height: auto;
    margin-top: 5dvh;
  }
  #courses-box{
    flex-direction: column;
    width: 100dvw;
  }
  .elem{
    width: 100dvw;
  }

  /* ------------------------ page 4--------------- */
  .page4 #heading{
    font-size: 2rem;
    width: 100dvw;
 
  }

  .imgcontainer{
    width: 100dvw;
    text-align: center;
  }
  .companies{
    height: 4rem;
    width: 4rem;
  }
  #p4button{
    font-size: 2rem;
  }
  #page5-comment{
    flex-direction: column;
    
  }
  #comment{
    width: 90dvw;
  }
  .p5p{
    font-size: 12px;
  }

}

  </style>
</head>

<body>
  <div id="cursor-blur"></div>
  <nav id="nav">
    <div id="nav_left">
        <div id="school_name">
            <a class="navbar-brand" href="index.php">Learn to Code</a>
        </div>
    </div>
    <div class="nav_right" id="nav_links">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="courses.php">Courses</a>
        <a href="contact.php">Contact</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="user/user_dashboard.php">Dashboard</a>
            <a href="user/profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
    <div id="mobile_menu" onclick="toggleMenu()">☰</div>
</nav>

  <main>

    <div class="page1 page">
      <div class="top"></div>
      <div class="center">
        <text>
          <h1>We only <span class="highlighted-text">teach</span></h1>
          <h1>What we are really</h1>
          <h1>really good at</h1>
        </text>
        <a href="courses.php"><button>Check-Courses Make an Impact</button></a>
      </div>
      <div class="bottom">
        <div class="achivement">
          <h2>24K+</h2>
          <p>Student taught</p>
        </div>
        <div class="achivement">
          <h2>9+</h2>
          <p>Instructor</p>
        </div>
        <div class="achivement">
          <h2>32+</h2>
          <p>Courses ..</p>
        </div>
      </div>
    </div>


    <div class="page2 page">
      <!--Feature-->
      <div id="features">
        <h1>Features</h1>
        <p>We try to provide our loyal users a rich and soothing experience in their path of learning
          We do our best ,but suggestions are welcomed</p>
      </div>
      <div id="features-ditails">
        <div class="features1">
          <i class="ri-css3-fill"></i>
          <div class="inner-ditails">
            <h3>Latest Technologies</h3>
            <p>Artificial Intelligence (AI), Internet of Things (IoT), Blockchain, Quantum Computing, Augmented Reality (AR), and Edge Computing are leading technologies.</p>
          </div>
        </div>


        <div class="features1">
          <i class="ri-landscape-fill"></i>
          <div class="inner-ditails">
            <h3>Toons Background</h3>
            <p>Backgrounds in animation are essential artworks that provide context and depth, enhancing scenes and guiding viewer focus on characters.</p>
          </div>
        </div>


        <div class="features1">
          <i class="ri-trophy-fill"></i>
          <div class="inner-ditails">

            <h3>Award Winning Design</h3>
            <p>Award-winning design emphasizes innovation, functionality, aesthetics, user understanding, honesty, sustainability, and attention to detail for impactful experience</p>
          </div>
        </div>

      </div>
      <!--/ feature-->
    </div>


    <div class="page3">
      <div id="page3-left">
        <div class="page3-poster">
          <h2>65%</h2>
          <p>Say NO!!</p>
          <i class="ri-team-fill"></i>
        </div>
        <div class="page3-poster">
          <h2>20%</h2>
          <p>Say Yes!!</p>
          <i class="ri-team-fill"></i>
        </div>
        <div class="page3-poster">
          <h2>15%</h2>
          <p>Can't Say!!</p>
          <i class="ri-team-fill"></i>
        </div>
      </div>
      <div id="page3-right">
        <h1>Is inclusive quality</h1>
        <h1>education affordable?</h1>
        <h3>(Revised and Updated for 2025)</h3>
        <p>Quality education must be inclusive and affordable, ensuring all children, regardless of background, can access learning opportunities and succeed.</p>
        <div id="more-btn">
          <a href="about.php">More...</a>
        </div>
      </div>
    </div>
    <div class="page6 ">

      <h1 style="  text-align: center; font-size: 3rem;    z-index: 10; margin: 40px 0 ;">COURSES </h1>
      <div id="courses-box">
        <div class="elem">
          <a href="courses.php"><h2>Fundamentals</h2></a>
        
          <img src="resouurces/images/home-img/100-Free-Online-Websites-to-Lear.png" alt="">
        </div>
        <div class="elem">
        <a href="courses.php"><h2>Front-end</h2></a>
         
          <img src="resouurces/images/home-img/course03.jpg" alt="">
        </div>
        <div class="elem">
        <a href="courses.php"><h2>Tailwindcss</h2></a>
        
          <img src="resouurces/images/home-img/course02.webp" alt="">
        </div>
        <div class="elem">
        <a href="courses.php"><h2> Node.js</h2></a>
         
          <img src="resouurces/images/home-img/course04.PNG" alt="">
        </div>
        <div class="elem">
        <a href="courses.php"><h2>Full-stack development</h2></a>
         
          <img src="resouurces/images/home-img/360_F_460763421_81kgNtVW47XUHIH7.webp" alt="">
        </div>
        <div class="elem">
        <a href="courses.php"><h2>UI/UX</h2></a>
          
          <img src="resouurces/images/home-img/course02.avif" alt="">
        </div>
      </div>
    </div>

    <div class="page4 page">
      <div class="top">
        <span id="heading">
          Top
          <span class="highlighted-text">companies</span>
          our student<br> working with
        </span>
      </div>

      <div class="center">
        <span class="imgcontainer">
          <img class="companies" src="https://ik.imagekit.io/sheryians/companies-logo/dark-theme/netlinklogo_A5k0VjsZL.webp?updatedAt=1713975960145" alt="">
          <img class="companies" src="https://ik.imagekit.io/sheryians/companies-logo/dark-theme/mindtree%20logo_sj0PIBh91l.webp?updatedAt=1713975960351" alt="">
          <img class="companies" src="https://ik.imagekit.io/sheryians/companies-logo/dark-theme/wallmartlogo_vR8JHQ_h20.webp?updatedAt=1713975960123" alt="">
        </span>
        <span class="imgcontainer">
          <img class="companies" src="https://ik.imagekit.io/sheryians/companies-logo/dark-theme/rapidops%20logo_ki9BX1CCNf.webp?updatedAt=1713975960174" alt="">
          <img class="companies" src="https://ik.imagekit.io/sheryians/companies-logo/dark-theme/tcs%20logo_PglyFlXHbC.webp?updatedAt=1713975960122" alt="">
          <img class="companies" src="https://ik.imagekit.io/sheryians/companies-logo/dark-theme/amazon%20logo_WQtU99KWC.webp?updatedAt=1713975960172" alt="">
          <img class="companies" src="https://ik.imagekit.io/sheryians/companies-logo/dark-theme/wipro%20logo_ezOSPx52r8.webp?updatedAt=1713975960224" alt="">
          <img class="companies" src="https://ik.imagekit.io/sheryians/companies-logo/dark-theme/gfg%20logo_gixPTWASN.webp?updatedAt=1713975960103" alt="">
        </span>
      </div>

      <div class="bottom">
        <button id="p4button" style="border-radius: 7px;">Explore More</button>
      </div>
    </div>

    <div class="page5 page">
      <div id="page5-heading">
        <h2>See What Our Customer Are Saying?</h2>
        <p>Thanks to our loyal customers and to their Suggestions</p>
        <p>It means a lot to us.</p>
      </div>
      <div id="page5-comment">
        <div id="comment">
          <p class="p5p">"provide flexible, accessible education, empowering learners with diverse resources and interactive tools to enhance knowledge and skills effectively"</p>
          <p class="comment-user">Manish Patel - Creative Student</p>
        </div>
        <div id="comment">
          <p class="p5p">"revolutionize education by offering personalized learning experiences, fostering engagement, and enabling access to quality resources anytime, anywhere"</p>
          <p class="comment-user">Diksha - Creative Student</p>
        </div>
      </div>
    </div>




    <?php include_once 'includes/footer.php'; ?>
  </main>


  <!-- <script src="script.js"></script> -->
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" integrity="sha512-onMTRKJBKz8M1TnqqDuGBlowlH0ohFzMXYRNebz+yOcc5TQr/zAKsthzhuv0hiyUKEiQEQXEynnXCvNTOk50dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="resouurces/js/script.js"></script>

</html>