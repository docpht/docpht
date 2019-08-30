<?php include 'src/views/partial/sidebar_button.php'; ?>

    <div class="card fade-in-fwd">
        <div class="card-body">
        <h3 class="mb-4"><?= $t->trans('Last logins'); ?></h3>
        <input class="form-control mb-4" id="last-logins-search" type="text" placeholder="<?= $t->trans('Search'); ?>">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered table-dark">
                    <thead>
                        <tr>
                        <th scope="col"><?= $t->trans('Access date'); ?></th>
                        <th scope="col"><?= $t->trans('Severity'); ?></th>
                        <th scope="col"><?= $t->trans('IP'); ?></th>
                        <th scope="col"><?= $t->trans('Username'); ?></th>
                        <th scope="col"><?= $t->trans('User agent'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="last-logins-table">
                        <?php 
                            if (!empty($userList)) {
                                $list = $userList;
                                $userList = array_reverse($list,true);
                                foreach ($userList as $key => $value) {
                                    echo '<tr>';
                                    echo '<th><small>' . $value['Access_date'] . '</small></th>';
                                    if ($value['Alert'] === true) {
                                        echo '<th><small class="text-danger font-weight-bold">' . $t->trans($value['Severity']) . '</small></th>';
                                    } else {
                                        echo '<th><small class="text-success font-weight-bold">' . $t->trans($value['Severity']) . '</small></th>';
                                    }
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