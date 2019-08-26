<?php include 'src/views/partial/sidebar_button.php'; ?>

    <div class="card fade-in-fwd">
        <div class="card-body">
        <h3 class="mb-4"><?= $t->trans('Last login'); ?></h3>
            <div class="table-responsive">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                        <th scope="col"><?= $t->trans('Access date'); ?></th>
                        <th scope="col"><?= $t->trans('IP'); ?></th>
                        <th scope="col"><?= $t->trans('Username'); ?></th>
                        <th scope="col"><?= $t->trans('User agent'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if (!empty($userList)) {
                                $list = $userList;
                                $userList = array_reverse($list,true);
                                foreach ($userList as $key => $value) {
                                    echo '<tr>';
                                    echo '<th>' . $value['Access_date'] . '</th>';
                                    echo '<th>' . $value['IP_address'] . '</th>';
                                    echo '<th>' . $value['Username'] . '</th>';
                                    echo '<th>' . $value['User_agent'] . '</th>';
                                    echo '</tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>
                <small><?= $t->trans('IP addresses are anonymized due to privacy'); ?></small>
            </div>
        </div>
    </div>