        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header text-center">
               <a href="<?= BASE_URL ?>"><h3><?= TITLE ?> <i class="fa fa-code" aria-hidden="true"></i></h3></a> 
            
            <?php 
                if (isset($_SESSION['Active'])) {
                    echo '<small>'.$t->trans('Welcome&nbsp').$_SESSION['Username'].'</small>';
                }
            ?>    
            </div>

            <ul class="list-inline text-center">
                <?php 
                if (isset($_SESSION['Active'])) {
                    echo '<li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="'.$t->trans("Logout").'">
                            <a href="logout" id="sk-logout" class="btn btn-outline-secondary btn-sm" role="button"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                        </li>';
                } else {
                    echo '<li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="'.$t->trans("Login").'">
                            <a href="login" id="sk-login" class="btn btn-outline-secondary btn-sm" role="button"><i class="fa fa-sign-in" aria-hidden="true"></i></a>
                        </li>';
                }
                if (isset($_SESSION['Active'])) {
                    echo '<li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="'.$t->trans("Create new").'">
                    <a href="page/create" id="sk-newPage" class="btn btn-outline-secondary btn-sm" role="button"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                    </li>';
                }
                if (isset($_SESSION['Active'])) {
                    echo '<li class="list-inline-item" data-toggle="tooltip" data-placement="top" title="'.$t->trans("Settings").'">
                    <a href="admin" id="sk-admin" class="btn btn-outline-secondary btn-sm" role="button"><i class="fa fa-cog" aria-hidden="true"></i></a>
                    </li>';
                }
                ?>
            </ul>

            <ul class="nav navbar-nav text-white text-center">
                <li><a href="#search" id="sk-search">Search<i class="fa fa-search" aria-hidden="true"></i></a></li>
            </ul>

            <div id="search">
                <button type="button" class="close">×</button>
                <form id="form-search" action="index.php?p=search" method="post">
                    <input type="search" name="search" minlength="5" value="" placeholder="Type the keywords here" autocomplete="off" required />
                </form>
            </div>


            <ul class="list-unstyled components">
            <?php
                if (SUBTITLE) {
                    echo '<p><b> '.SUBTITLE.' </b></p>';
                }
            ?>
                <!-- Navigation -->
            <?php 

                function dirPage($dir) {
                    $contents = array();
                    foreach (scandir($dir) as $node) {
                        if ($node == '.' || $node == '..' || $node == '.gitignore') continue;
                        if (is_dir($dir . '/' . $node)) {
                            $contents[$node] = dirPage($dir . '/' . $node);
                        } else {
                            $contents[] = $node;
                        }
                    }
                
                    return $contents;
                }
                
                $url = "$_SERVER[REQUEST_URI]";
                $parse = parse_url($url)['path'];
                $explode = explode('/', $parse);
                $page = array_reverse($explode)[0];
                $topic = array_reverse($explode)[1];

                if (file_exists('pages')) {
                    $menu = dirPage("pages");
                    if ($menu) {
                        echo '<li>';
                        foreach ($menu as $key => $folders) {
                            $key_replace = str_replace('-', ' ', $key);
                            if (isset($topic) && $topic === $key) {
                                $active = 'menu-active';
                                $show = 'show';
                            } else {
                                $active = ''; 
                                $show = '';
                            }
                            echo '<a href="#'.$key.'-nav" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle '.$active.' ">'. ucfirst($key_replace) .'</a>';
                            echo '<ul class="collapse list-unstyled '.$show.' " id="'.$key.'-nav">';
                        foreach ($folders as $file) {
                            $filename = pathinfo($file, PATHINFO_FILENAME); 
                            $file_replace = str_replace('-', ' ', $filename);
                            $link = 'page/'.$key.'/'.$filename;
                            if (isset($page) && $page === $filename and isset($topic) && $topic === $key) {
                                $active = 'class="menu-active"';
                            } else {
                                $active = ''; 
                            }
                            echo '<li><a href="'.$link.'" '.$active.' >'.ucfirst($file_replace).'</a></li>';
                        } 
                            echo '</ul>';
                        }
                        echo '<li>';
                    }
                }
            ?>
            
            </ul>
            
            
            <ul class="list-unstyled CTAs text-center">
            <?php  
            if (DOWNLOAD) {
               echo '
                    <li>
                        <a href="'.DOWNLOAD.'" class="download">Download source</a>
                    </li>
                    ';
            } 
            
            if (GITHUB) {
                echo '
                     <li>
                        <a href="'.GITHUB.'" class="github">GitHub</a>
                     </li>
                     ';
             }

            ?>
            </ul>

        </nav>