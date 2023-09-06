<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DFS - About Us</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/upload_document.css">
    <script src="https://kit.fontawesome.com/c3573e9c36.js" crossorigin="anonymous"></script>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <?php
        include "menu/navbar.php";
    ?>
    <div class="container-fluid p-0 m-0" style="background-color:#CBC3E3">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/documentstore.png" class="d-block w-100" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="img/managedoc.png" class="d-block w-100" alt="Slide 2">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>

        <!-- About Us Section -->
        <div class="m-0 mt-2 text-center border-bottom border-dark">
            <div class="p-4 pt-1 m-0">
                <h1 class="p-4"><strong>About us</strong></h1>
                <div class="row" st>
                    <p class="lh-base">Welcome to Document Filing System, where efficiency meets security in managing your valuable documents. With a strong foundation in technology and a dedication to streamlining document management, we offer a comprehensive platform to safeguard, organize, and share critical information. Our team is driven by a vision to revolutionize document handling, combating forgery and enhancing collaboration. We understand the importance of authenticity, and our system ensures verified issuer accounts, recipient notifications, and document sharing with integrity. Seamlessly bridging the gap between issuers and recipients, we empower businesses and individuals to confidently navigate the digital document landscape. Trust us to safeguard your documents while fostering seamless connectivity.</p>
                </div>
            </div>
        </div>

        
        <!-- FAQs section -->
        <div class="row m-0 mt-3 pb-5">
            <div class="col-md-12">
                <div>
                    <h1 class="p-4 text-center"><strong>Frequently asked questions</strong></h1>
                </div>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                                FAQ 1:What is the main purpose of the Document Filing System?
                            </button>
                        </h2>
                        <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">The main purpose of the Document Filing System is to provide a secure platform for verified issuers to upload and dedicate various types of documents to individuals (recipients), ensuring document authenticity and minimizing the risk of forgery.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                FAQ 2: How does the system verify and authenticate issuers?
                            </button>
                        </h2>
                        <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Issuers are verified and authenticated through their email addresses or email domain names. They must also submit proof of their identity, which is then reviewed and validated by the system administrator before their accounts are activated.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                FAQ 3: What actions can activated issuers perform within the system?
                            </button>
                        </h2>
                        <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Activated issuers have the capability to upload different documents (such as appraisal letters, certificates) to the system. They can dedicate these documents to specific recipients using the recipients' email addresses or mobile phone numbers.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                                FAQ 4: How do recipients access documents dedicated to them and manage their accounts?
                            </button>
                        </h2>
                        <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Recipients receive notifications (email or SMS) about dedicated documents. They can create accounts using their verified email addresses or mobile phone numbers. Once signed in, recipients can access a collection of documents, consolidate multiple verified accounts, and even upload their own documents.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                                FAQ 5: How does the system ensure the authenticity of the documents and allow sharing with viewers?
                            </button>
                        </h2>
                        <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">The system verifies document formats and integrity upon upload. Recipients can generate shareable links for specific documents or collections, which can be shared with viewers. These links allow viewers to access documents while displaying verification status and issuer information to establish trustworthiness.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        include "menu/footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
