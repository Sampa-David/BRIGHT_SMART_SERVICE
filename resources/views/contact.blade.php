<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - {{config('app.name')}}</title>

             

    <!-- AOS JS --> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Quicksand:wght@500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/contact-standalone.css') }}" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom Variables -->
        <link rel="stylesheet" href="{{ asset("css/views/contact.blade.css") }}">
</head>
<body>

    <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p>Pour toute question sur nos services technologiques</p>
        </div>
        
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center">
                <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
                    <div class="contact-form-card">
                        <div class="form-header">
                            <a href="{{route('welcome')}}" class="logo-link">
                                <div class="header-icon">
                                    <img src="{{ asset('img/bright.jpg') }}" alt="Logo Bright" style="width: 100%; height: 100%; object-fit: contain;">
                                </div>
                            </a>
                            <h3>Démarrons la conversation</h3>
                            <p>Notre équipe est à votre écoute pour répondre à toutes vos questions.</p>
                        </div>

                        <form action="{{ route('contact.send') }}" method="post" class="php-email-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="name" class="form-control" placeholder="Votre nom" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Votre email" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control" name="subject" placeholder="Sujet de votre message" required>
                            </div>

                            <div class="mb-3">
                                <select name="contact_method" id="contactMethod" class="form-control" required>
                                    <option value="">Comment souhaitez-vous être contacté ?</option>
                                    <option value="email">Par email</option>
                                    <option value="whatsapp">Par WhatsApp</option>
                                </select>
                            </div>

                            <div id="phoneField" class="mb-3" style="display: none;">
                                <input type="tel" name="phone" class="form-control" placeholder="Votre numéro WhatsApp avec indicatif (optionnel)">
                                <small class="form-text text-muted">Ex: +33612345678 ou 0612345678</small>
                            </div>

                            <div class="mb-4">
                                <textarea class="form-control" name="message" rows="4" placeholder="Décrivez votre demande..." required></textarea>
                            </div>

                            <div class="my-3">
                                <div class="feedback-message loading">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <span>Envoi en cours...</span>
                                </div>
                                <div class="feedback-message error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <span>Une erreur est survenue. Veuillez réessayer.</span>
                                </div>
                                <div class="feedback-message sent-message">
                                    <i class="bi bi-check-circle"></i>
                                    <span>Votre message a été envoyé avec succès !</span>
                                </div>
                            </div>

                            <button type="submit" class="submit-btn">
                                <span>Envoyer le message</span>
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                    <div class="contact-info-area">
                        <div class="info-header">
                            <h3>Besoin d'un service ?</h3>
                            <p>Notre équipe de professionnels est là pour vous accompagner dans tous vos besoins.</p>
                        </div>

                        <div class="contact-methods">
                            <a href="mailto:njonoussistephen@gmail.com?subject=Demande%20de%20renseignements%20-%20Services%20Bright&body=Bonjour%2C%0A%0AJe%20vous%20contacte%20au%20sujet%20de%20vos%20services.%0A%0ACordialement" class="text-decoration-none">
                                <div class="method-card" data-aos="zoom-in" data-aos-delay="250">
                                    <div class="card-icon">
                                        <i class="bi bi-envelope-at"></i>
                                    </div>
                                    <div class="card-content">
                                        <h5>Email</h5>
                                        <p>brightsmartservice@gmail.com</p>
                                        <span class="response-time">Réponse sous 2-4 heures</span>
                                    </div>
                                </div>
                            </a>

                            <a href="https://wa.me/237688661642?text=Bonjour%2C%20je%20vous%20contacte%20au%20sujet%20de%20vos%20services%20technologiques." target="_blank" class="text-decoration-none">
                                <div class="method-card" data-aos="zoom-in" data-aos-delay="300">
                                    <div class="card-icon">
                                        <i class="bi bi-whatsapp"></i>
                                    </div>
                                    <div class="card-content">
                                        <h5>WhatsApp</h5>
                                        <p><i class="bi bi-whatsapp"></i> +237 6 88 66 16 42</p>
                                        <span class="response-time">9h-18h du lundi au vendredi</span>
                                    </div>
                                </div>
                            </a>

                            <div class="method-card" data-aos="zoom-in" data-aos-delay="350">
                                <div class="card-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="card-content">
                                    <h5>Notre atelier</h5>
                                    <p>Kano Bertoua-Cameroun</p>
                                    <span class="response-time">Ouvert du lundi au vendredi</span>
                                </div>
                            </div>
                        </div>

                        <div class="additional-info" data-aos="fade-up" data-aos-delay="400">
                            <div class="info-stats">
                                <div class="stat-item">
                                    <div class="stat-number">24h</div>
                                    <div class="stat-label">Délai moyen d'intervention</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">98%</div>
                                    <div class="stat-label">Satisfaction client</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">150+</div>
                                    <div class="stat-label">Appareil installe et réparés</div>
                                </div>
                            </div>

                            <div class="social-connect">
                                <h6>Suivez-nous</h6>
                                <div class="social-links">
                                    <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                                    <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                                    <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{route('welcome')}}"></a>
    </section>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        // Gestion du champ téléphone dynamique
        document.addEventListener('DOMContentLoaded', function() {
            const contactMethod = document.getElementById('contactMethod');
            const phoneField = document.getElementById('phoneField');
            const phoneInput = phoneField.querySelector('input[name="phone"]');

            function togglePhoneField() {
                if (contactMethod.value === 'whatsapp') {
                    phoneField.style.display = 'block';
                    phoneInput.required = true;
                    // Animation d'apparition
                    phoneField.style.opacity = '0';
                    phoneField.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        phoneField.style.transition = 'all 0.3s ease-out';
                        phoneField.style.opacity = '1';
                        phoneField.style.transform = 'translateY(0)';
                    }, 0);
                } else {
                    phoneField.style.display = 'none';
                    phoneInput.required = false;
                    phoneInput.value = ''; // Réinitialiser la valeur
                }
            }

            // Vérifier l'état initial
            togglePhoneField();

            // Écouter les changements
            contactMethod.addEventListener('change', togglePhoneField);

            // Validation personnalisée du numéro de téléphone
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value;
                // Permet les chiffres, le + et les espaces
                if (!value.startsWith('+') && value.length > 0) {
                    // Si ça ne commence pas par +, on garde que les chiffres
                    value = value.replace(/[^\d]/g, '');
                } else {
                    // Si ça commence par +, on le garde et on nettoie le reste
                    value = '+' + value.substring(1).replace(/[^\d]/g, '');
                }
                e.target.value = value;
            });
        });
    </script>

    <div class="back-to-home">
        <a href="{{route('welcome')}}" class="btn">
            <i class="bi bi-arrow-left me-2"></i>Retour à l'accueil
        </a>
    </div>
</body>
</html>

