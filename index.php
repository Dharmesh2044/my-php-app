<?php
include('db_connect.php'); 

// Session start karna zaroori hai taaki redirect ke baad message dikha sakein
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    // Input sanitization
    $name    = mysqli_real_escape_string($conn, $_POST['user_name']);
    $email   = mysqli_real_escape_string($conn, $_POST['user_email']);
    $phone   = mysqli_real_escape_string($conn, $_POST['user_phone']);
    $message = mysqli_real_escape_string($conn, $_POST['user_message']);

    // Database insertion with default status 'new'
    $query = "INSERT INTO contact_messages (name, email, phone, message, status) 
              VALUES ('$name', '$email', '$phone', '$message', 'new')";

    if (mysqli_query($conn, $query)) {
        // Success message ko session mein store karein
        $_SESSION['form_success'] = "Message sent successfully! We will contact you soon.";
        
        // Redirect to the same page (is se POST data clear ho jata hai)
        header("Location: " . $_SERVER['PHP_SELF'] . "#contact");
        exit();
    } else {
        $error_msg = "Error: " . mysqli_error($conn);
    }
}

// Page reload hone par check karein ki kya koi success message session mein hai
if (isset($_SESSION['form_success'])) {
    $success_msg = $_SESSION['form_success'];
    unset($_SESSION['form_success']); // Ek baar dikhane ke baad delete kar dein
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./img/logo1.png">
    <title>Shareware Technology</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="./">
                    <img src="./img/logo1.png" alt="Logo" width="45" height="45" class="d-inline-block align-text-top me-2">
                    <span class="text-warning">SHAREWARETECH</span>
                </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav ms-auto align-items-center text-center py-3 py-lg-0">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="./">Home</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link px-3" href="./#about">About</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link px-3" href="./#services">Services</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link px-3" href="./#achievements">Achievements</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link px-3" href="./#contact">Contact</a>
                    </li>
                    
                    <li class="nav-item mt-3 mt-lg-0">
                        <a class="btn btn-warning fw-bold px-4 rounded-pill shadow-sm ms-lg-3" href="./#contact">
                            Get Started
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header id="home" class="hero-section text-center position-relative overflow-hidden">
    <div class="shape-1"></div>
    <div class="shape-2"></div>
    
    <div class="container px-4 position-relative" style="z-index: 2;">
        <div class="hero-content">
            <h6 class="text-uppercase tracking-widest mb-3 text-white-50 fade-in-up">Innovative Software Solutions</h6>
            <h1 class="display-2 fw-semibold mb-4 mb-md-5 text-warning scale-in">
                Technology to Make Life Easier <br class="d-none d-md-block"> 
            </h1>
            
            <div class="d-flex flex-wrap gap-3 justify-content-center fade-in-up-delay-2">
                <a href="#services" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg hover-glow small-mobile-btn">
                    Our Services <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a href="#contact" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill glass-btn small-mobile-btn">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</header>

    <section id="about" class="py-5">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="position-relative mx-auto" style="max-width: 500px;">
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80" alt="About Us" class="img-fluid rounded-3 shadow-lg">
                        <div class="bg-warning position-absolute bottom-0 start-0 p-3 m-3 rounded shadow-sm d-none d-md-block">
                            <h3 class="fw-bold mb-0">10+</h3>
                            <p class="mb-0 text-dark small">Years of Innovation</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5 text-center text-lg-start">
                    <h6 class="text-primary fw-bold text-uppercase tracking-wider">Who We Are</h6>
                    <h2 class="display-5 fw-bold mb-4">Driving the Future of <span class="text-warning">Diamond Technology</span></h2>
                    <p class="lead text-muted mb-4">Leading software solutions tailored specifically for the jewelry industry.</p>
                    <div class="row g-3 mb-4 text-start justify-content-center justify-content-lg-start">
                        <div class="col-sm-6"><i class="fas fa-check-circle text-warning me-2"></i> Precision Engineering</div>
                        <div class="col-sm-6"><i class="fas fa-check-circle text-warning me-2"></i> 24/7 Expert Support</div>
                    </div>
                    <a href="#contact" class="btn btn-dark btn-lg px-4 rounded-3">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- service-->
    <section id="services" class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase">Our Expertise</h6>
                <h2 class="display-6 fw-bold">Specialized Diamond Solutions</h2>
                <div class="bg-warning mx-auto mt-2" style="width: 70px; height: 4px; border-radius: 2px;"></div>
            </div>
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card service-card p-4 border-0 shadow-sm h-100 text-center">
                        <div class="icon-box mb-4 mx-auto">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h4 class="fw-bold">Inventory Management</h4>
                        <p class="text-muted small">
                            Real-time tracking with advanced analytics & reporting.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card service-card p-4 border-0 shadow-sm h-100 text-center">
                        <div class="icon-box mb-4 mx-auto">
                            <i class="fas fa-broadcast-tower"></i>
                        </div>
                        <h4 class="fw-bold">Inventory Management</h4>
                        <p class="text-muted small">
                            Real-time tracking with advanced analytics & reporting.
                        </p>
                    </div>    
                </div>
                <div class="col-12 col-md-6 col-lg-4 mx-auto">
                    <div class="card service-card p-4 border-0 shadow-sm h-100 text-center">
                        <div class="icon-box mb-4 mx-auto">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h4 class="fw-bold">Inventory Management</h4>
                        <p class="text-muted small">
                            Real-time tracking with advanced analytics & reporting.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- achievements -->
    <section id="achievements" class="py-5" style="background-color: #1a1d20;">
        <div class="container py-4">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card border-0 p-3">
                        <i class="fas fa-gem fa-2x text-warning mb-2"></i>
                        <h2 class="fw-bold text-white mb-0">10M+</h2>
                        <p class="small text-secondary mb-0">Diamonds</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card border-0 p-3">
                        <i class="fas fa-users fa-2x text-warning mb-2"></i>
                        <h2 class="fw-bold text-white mb-0">200+</h2>
                        <p class="small text-secondary mb-0">Merchants</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card border-0 p-3">
                        <i class="fas fa-globe-asia fa-2x text-warning mb-2"></i>
                        <h2 class="fw-bold text-white mb-0">15+</h2>
                        <p class="small text-secondary mb-0">Years</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card border-0 p-3">
                        <i class="fas fa-shield-alt fa-2x text-warning mb-2"></i>
                        <h2 class="fw-bold text-white mb-0">100%</h2>
                        <p class="small text-secondary mb-0">Security</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- contact -->
    <section id="contact" class="py-5">
        <div class="container py-4">
            <div class="row g-5">
                <div class="col-lg-5 text-center text-lg-start">
                    <h6 class="text-primary fw-bold text-uppercase tracking-wider">Contact Us</h6>
                    <h2 class="display-6 fw-bold mb-4">Let's Discuss Your <span class="text-warning">Next Project</span></h2>
                    <p class="text-muted mb-5">Our expert team provides seamless technology integration for your jewelry business.</p>
                    
                    <div class="d-flex align-items-center mb-4 justify-content-center justify-content-lg-start">
                        <div class="icon-box-small me-3"><i class="fas fa-map-marker-alt text-primary"></i></div>
                        <div class="text-start">
                            <h6 class="mb-0 fw-bold">Office</h6>
                            <p class="text-muted small mb-0">Katargam, Surat</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 justify-content-center justify-content-lg-start">
                        <div class="icon-box-small me-3"><i class="fas fa-phone-alt text-primary"></i></div>
                        <div class="text-start">
                            <h6 class="mb-0 fw-bold">Call Us</h6>
                            <p class="text-muted small mb-0">+91 98XXX XXXXX</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card border-0 shadow-lg p-3 p-md-5 rounded-4">
                        <form action="" method="POST">
                            <div class="row g-3">
                                <?php if(isset($success_msg)): ?>
                                    <div class="alert alert-success alert-dismissible fade show py-2 small shadow-sm" role="alert">
                                        <i class="fas fa-check-circle me-2"></i> <?php echo $success_msg; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding: 0.8rem;"></button>
                                    </div>
                                <?php endif; ?>

                                <?php if(isset($error_msg)): ?>
                                    <div class="alert alert-danger py-2 small shadow-sm"><?php echo $error_msg; ?></div>
                                <?php endif; ?>

                                <div class="col-md-6">
                                    <div class="form-floating mb-2">
                                        <input type="text" name="user_name" class="form-control" id="name" placeholder="Name" required>
                                        <label for="name">Full Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-2">
                                        <input type="email" name="user_email" class="form-control" id="email" placeholder="Email" >
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-2">
                                        <input type="tel" name="user_phone" class="form-control" id="phone" placeholder="Phone" required>
                                        <label for="phone">Contact Number</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <textarea name="user_message" class="form-control" id="message" style="height: 120px"  placeholder="Message"></textarea>
                                        <label for="message">Your Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="submit" class="btn btn-warning w-100 py-3 fw-bold rounded-pill">
                                        Send Message <i class="fas fa-paper-plane ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white pt-5 pb-4 mt-auto">
        <div class="container">
            <div class="row g-4 text-center text-md-start">
                <div class="col-md-4">
                    <h5 class="text-uppercase mb-3 fw-bold text-warning">Shareware Technology</h5>
                    <p class="small text-secondary">Leading digital transformation in the diamond industry with precision.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="text-uppercase mb-3 fw-bold text-warning">Quick Links</h5>
                    <div class="row">
                        <div class="col-6"><a href="#home" class="text-secondary text-decoration-none d-block mb-2 small">Home</a></div>
                        <div class="col-6"><a href="#services" class="text-secondary text-decoration-none d-block mb-2 small">Services</a></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="text-uppercase mb-3 fw-bold text-warning">Get In Touch</h5>
                    <p class="text-secondary small mb-1"><i class="fas fa-home me-2"></i> Surat, Gujarat, India</p>
                    <p class="text-secondary small mb-0"><i class="fas fa-envelope me-2"></i> info@sharewaretech.com</p>
                </div>
            </div>
            <hr class="mt-4 border-secondary opacity-25">
            <p class="text-center text-secondary small mb-0">© 2026 Shareware Technology. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script> 
        // Mobile Navbar Auto-Close Logic
        document.querySelectorAll('.navbar-nav .nav-link, .btn-warning').forEach(link => {
            link.addEventListener('click', () => {
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse.classList.contains('show')) {
                    new bootstrap.Collapse(navbarCollapse).hide();
                }
            });
        });
    </script>

    <!--- inspect block --->
    <script>
        // 1. Right Click Block karne ke liye
        /*document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // 2. Keyboard Shortcuts Block karne ke liye (F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U)
        document.onkeydown = function(e) {
            if (event.keyCode == 123) { // F12
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) { // Ctrl+Shift+I
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) { // Ctrl+Shift+C
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) { // Ctrl+Shift+J
                return false;
            }
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) { // Ctrl+U (View Source)
                return false;
            }
        };*/
    </script>
</body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 