<?php include 'src/views/partial/sidebar_button.php'; ?>

    <div class="card fade-in-fwd">
        <div class="card-body">
        <h3 class="mb-4"><?= $t->trans('Last logins'); ?></h3>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered table-dark">
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
                                    echo '<th><small>' . $value['Access_date'] . '</small></th>';
                                    echo '<th><small>' . $value['IP_address'] . '</small></th>';
                                    echo '<th><small>' . $value['Username'] . '</small></th>';
                                    echo '<th><small>' . $value['User_agent'] . '</small></th>';
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