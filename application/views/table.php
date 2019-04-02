<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>

<div class="container">
    <div class="row">


        <div class="col-md-12">
            <h4></h4>
            <div class="table-responsive">


                <table id="mytable" class="table table-bordred table-striped">

                    <thead>

                    <th>id</th>
                    <th>Phone</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Price</th>
                    <th>current status</th>
                    <th>set status</th>


                    </thead>
                    <tbody>

                    <? foreach ($orders as $value) : ?>
                        <tr>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['phone'] ?></td>
                            <td><?= $value['start_address'] ?></td>
                            <td><?= $value['stop_address'] ?></td>
                            <td><?= $value['price'] ?></td>
                            <td>
                                <?= $value['status_id'] ?>
                            </td>
                            <td>
                                <form action="<?= base_url().'onplace/update'?>" method="post">

                                    <select name="status_id">
                                        <? for ($i = 1 ; $i < 4 ; $i++) :?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                        <? endfor ?>
                                    </select>
                                    <input type="hidden" name="id" value="<?=$value['id']?>" />
                                    <input type="submit" value="send">
                                </form>
                            </td>


                        </tr>
                    <? endforeach; ?>


                    </tbody>

                </table>

                <div class="clearfix"></div>


            </div>

        </div>
    </div>
</div>

