<?php 
require_once 'verificar-sesion.php'; 
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Calendario Escolar</title>

    <link rel="stylesheet" href="../../assets/css/font.css">
    <link rel="stylesheet" href="../../assets/css/global.css">
    <link rel="stylesheet" href="../../assets/css/calendar-styles.css">
    <link rel="icon" href="../../assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="layout">
    
    <!-- === HEADER SECTION === -->
        <header class="header">
                
            <div class="header__container">

                <img class="header__logo" src="../../assets/img/favicon.png">

                <p class="header__title">Complejo Educativo Rafael Rangel</p>

                <!-- Redes del Complejo Educativo -->
                <ul class="header__social-media">
                    <li class="social-media__li">
                        <a class="social-media__link" href="https://www.facebook.com/liceobolibariano.rafaelrangel" target="_blank">
                            <svg class="social-media__logo" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
                        </a>
                    </li>
                    <li class="social-media__li">
                        <a class="social-media__link" href="https://www.instagram.com/rafaelrangel852021/" target="_blank">
                            <svg class="social-media__logo" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M16.5 7.5v.01" /></svg>
                        </a>
                    </li>
                    <li class="social-media__li">
                        <a class="social-media__link" href="https://x.com/RAFAELR15973838" target="_blank">
                            <svg class="social-media__logo" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" /><path d="M9 8l6 8" /><path d="M15 8l-6 8" /></svg>
                        </a>
                    </li>
                </ul>
            </div>

            <nav class="header__nav">
                <!-- Menú para Móviles -->
                <button class="nav__hamburger" aria-label="Abrir menú">
                    <svg class="hamburger-icon" viewBox="0 0 24 24" width="24" height="24"> <path fill="currentColor" d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
                        
                    <svg class="close-icon" viewBox="0 0 24 24" width="24" height="24" style="display:none;"><path fill="currentColor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                </button>
                    
                <!-- Menú de Navegación -->
                <ul class="nav__ul">
                    <li class="ul__item"><a class="ul__link" href="inicio-docente.php">Inicio</a></li>
                    <li class="ul__item"><a class="ul__link" href="calendar-docente.php">Calendario</a></li>
                    <li class="ul__item"><a class="ul__link" href="student-management/student-management.php">Gestión de Estudiantes</a></li> 
                    <li class="ul__item"><a class="ul__link" href="about-us-docente.php"> Sobre Nosotros </a></li>
                    <li class="ul__item"><a class="ul__link" href="help-docente.php">Ayuda</a></li>
                    <li class="ul__item ul__item--sign-in"><a class="ul__link" href="../cerrar-sesion.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </header>


        <!-- === MAIN SECTION === -->
        <main>
            
            <<div class="main-title-container">
                <h1 class="main__title-professor">Calendario Escolar</h1>
                
                <div class="link-container">
                    <a href="events-management/events-management.php" class="events-management-link"><i class="fa-solid fa-pen-to-square"></i>Gestionar el Calendario</a>
                </div>
            </div>

            
            <div class="legend-container">
                <div class="legend__item">
                    <div class="item__color-red"></div>
                    <p class="item__day">Días no laborables</p>
                </div>
                <div class="legend__item">
                    <div class="item__color-green"></div>
                    <p class="item__day">Día de interés</p>
                </div>
            </div>

            <div class="calendar-container">

                <div id="1" class="month january">
                    <h2 class="month__title">Enero</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                        <li>31</li>
                    </ol>
                </div>
                
                <div id="2" class="month february">
                    <h2 class="month__title">Febrero</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                    </ol>
                </div>

                <div id="3" class="month march">
                    <h2 class="month__title">Marzo</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                        <li>31</li>
                    </ol>
                </div>

                <div id="4" class="month april">
                    <h2 class="month__title">Abril</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                    </ol>
                </div>

                <div id="5" class="month may">
                    <h2 class="month__title">Mayo</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                        <li>31</li>
                    </ol>
                </div>
                
                <div id="6" class="month june">
                    <h2 class="month__title">Junio</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                    </ol>
                </div>

                <div id="7" class="month july">
                    <h2 class="month__title">Julio</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                        <li>31</li>
                    </ol>
                </div>

                <div id="8" class="month august">
                    <h2 class="month__title">Agosto</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                        <li>31</li>
                    </ol>
                </div>

                <div id="9" class="month september">
                    <h2 class="month__title">Septiembre</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                    </ol>
                </div>

                <div id="10" class="month october">
                    <h2 class="month__title">Octubre</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                        <li>31</li>
                    </ol>
                </div>

                <div id="11" class="month november">
                    <h2 class="month__title">Noviembre</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                    </ol>
                </div>

                <div id="12" class="month december">
                    <h2 class="month__title">Diciembre</h2>
                    <ol class="month__days">
                        <!-- Días de la semana -->
                        <li class="day-week">Dom</li>
                        <li class="day-week">Lun</li>
                        <li class="day-week">Mar</li>
                        <li class="day-week">Mié</li>
                        <li class="day-week">Jue</li>
                        <li class="day-week">Vie</li>
                        <li class="day-week">Sáb</li>

                        <!-- Fechas -->
                        <li>1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>6</li>
                        <li>7</li>
                        <li>8</li>
                        <li>9</li>
                        <li>10</li>
                        <li>11</li>
                        <li>12</li>
                        <li>13</li>
                        <li>14</li>
                        <li>15</li>
                        <li>16</li>
                        <li>17</li>
                        <li>18</li>
                        <li>19</li>
                        <li>20</li>
                        <li>21</li>
                        <li>22</li>
                        <li>23</li>
                        <li>24</li>
                        <li>25</li>
                        <li>26</li>
                        <li>27</li>
                        <li>28</li>
                        <li>29</li>
                        <li>30</li>
                        <li>31</li>
                    </ol>
                </div>
            
            </div>

        </main>


        <!-- === FOOTER SECTION === -->
        <footer class="footer">
            <p class="footer__description"> Ubícanos: </p>
            <p class="footer__description"> Avenida 6 con calle Río de Janeiro, sector La Plata. Parroquia Juan Ignacio Montilla, municipio Valera, estado Trujillo </p>
            <p class="footer__description"> Complejo Educativo Rafael Rangel &copy; 2025 </p>
        </footer>
    </div>

    <script src="../../assets/js/nav-bar.js"></script>
    <script src="../../assets/js/load-events.js"></script>
</body>
</html>