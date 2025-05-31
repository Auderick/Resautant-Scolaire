        </div>
    </main>
    <footer class="footer mt-auto py-3 bg-dark text-white shadow-lg">
        <div class="container">
            <div class="row py-2">
                <div class="col-md-4 text-center text-md-start">
                    <p class="small mb-0">&copy; <?php echo date('Y'); ?> - Restaurant Scolaire Leignes sur Fontaine</p>
                </div>
                <div class="col-md-4 text-center">
                    <p class="small mb-0">
                        Développé par <a href="https://webtransform.fr/" target="_blank" class="link-light text-decoration-underline">WebTransform</a>
                    </p>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <p class="small mb-0">Tous droits réservés</p>
                </div>
            </div>        </div>
    </footer>    <!-- JavaScript Dependencies -->
    <script src="<?php echo getBasePath(); ?>/public/vendor/jquery/jquery-3.7.1.min.js" type="text/javascript"></script>    <script src="<?php echo getBasePath(); ?>/public/vendor/bootstrap/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script>
        // Gestion améliorée de la navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Rendre active la navigation courante
            const currentPath = window.location.pathname;
            const basePath = '<?php echo getBasePath(); ?>';
            
            document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href)) {
                    link.classList.add('active');
                    link.setAttribute('aria-current', 'page');
                    
                    // Trouver et activer le parent si c'est un sous-menu
                    const dropdownParent = link.closest('.dropdown-menu');
                    if (dropdownParent) {
                        const parentToggle = dropdownParent.previousElementSibling;
                        if (parentToggle && parentToggle.classList.contains('dropdown-toggle')) {
                            parentToggle.classList.add('active');
                        }
                    }
                }
            });

            // Gérer les liens de navigation
            document.querySelectorAll('a[href]:not([href^="http"]):not([href^="#"])').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href && !href.startsWith('http') && !href.startsWith('#')) {
                        if (!href.startsWith('/') && !href.startsWith('./') && !href.startsWith('../')) {
                            this.href = basePath + '/' + href;
                        }
                    }
                });
            });
        });
    </script>
    <script src="<?php echo getBasePath(); ?>/public/vendor/select2/select2.min.js" type="text/javascript"></script>

    <!-- Application Scripts -->
    <script src="<?php echo getBasePath(); ?>/public/js/logger.js" type="text/javascript"></script>
    <script src="<?php echo getBasePath(); ?>/public/js/ventes.js" type="text/javascript"></script>
    <script src="<?php echo getBasePath(); ?>/public/js/syntheses.js" type="text/javascript"></script>
    <script src="<?php echo getBasePath(); ?>/public/js/achats.js" type="text/javascript"></script>
    <script src="<?php echo getBasePath(); ?>/public/js/stocks.js" type="text/javascript"></script>
    <script src="<?php echo getBasePath(); ?>/public/js/commandes.js" type="text/javascript"></script>
    <script src="<?php echo getBasePath(); ?>/public/js/menus.js" type="text/javascript"></script>    <script src="<?php echo getBasePath(); ?>/public/js/allergenes.js" type="text/javascript"></script>
    <!-- Bootstrap initialization -->
    <script src="<?php echo getBasePath(); ?>/public/js/bootstrap-init.js" type="text/javascript"></script>
</body>
</html>