        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header text-center">
               <a href="<?= BASE_URL ?>"><h3><?= TITLE ?> <i class="fa fa-code" aria-hidden="true"></i></h3></a> 
            
            <?php 
                if (isset($_SESSION['Active'])) {
                    echo '<small><i class="fa fa-user" aria-hidden="true"></i> '.$t->trans('Welcome&nbsp;').$_SESSION['Username'].'</small>';
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
                <li><a href="#search" id="sk-search"><?= $t->trans('Search'); ?> <i class="fa fa-search" aria-hidden="true"></i></a></li>
            </ul>

            <?php $search = ''; ?>
            <div id="search">
                <button type="button" class="close">×</button>
                <form id="form-search" action="page/search" method="post">
                    <input type="search" name="search" minlength="5" value="<?php $search; ?>" placeholder="<?= $t->trans('Type the keywords here'); ?>" autocomplete="off" required />
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


        $topics = $this->pageModel->getUniqTopics();
                
        $url = "$_SERVER[REQUEST_URI]";
        $parse = parse_url($url)['path'];
        $explode = explode('/', $parse);
        $filenameURL = array_reverse($explode)[0];
        $topicURL = array_reverse($explode)[1];

        if (!is_null($topics)) {
            if (!empty($topics)) {
                echo '<li>';
                foreach ($topics as $topic) {
                    $topicTitle = str_replace('-', ' ', $topic);
                        if (isset($topicURL) && $topicURL === $topic) {
                        $active = 'menu-active';
                            $show = 'show';
                        } else {
                            $active = ''; 
                            $show = '';
                        }
                    echo '<a href="#'.$topic.'-side-navigation" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle '.$active.' ">'. ucfirst($topicTitle) .'</a>';
                    echo '<ul class="collapse list-unstyled '.$show.' " id="'.$topic.'-side-navigation">';

                    $pages = $this->pageModel->getPagesByTopic($topic);

                    if (!empty($pages)) {
                        foreach($pages as $page) {
                            if (isset($filenameURL) && $filenameURL === $page['filename'] and isset($topicURL) && $topicURL === $page['topic']) {
                                $active = 'class="menu-active"';
                            } else {
                                $active = ''; 
                            }
                            $filename = $page['filename']; 
                            $filenameTitle = str_replace('-', ' ', $page['filename']);
                            $link = 'page/'.$page['slug'];
                            echo '<li><a href="'.$link.'" '.$active.' >'.ucfirst($filenameTitle).'</a></li>';
                        }
                    }

                    echo '</ul>';
                }
                echo '</li>';
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