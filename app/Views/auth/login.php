<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Sign In</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    </head>
    <body>

        <div class="container">
            <div class="row" style="margin-top:45px">
                
                    <div class="col-md-4 offset-md-4">
                        <h4>Sign In</h4>
                        <hr>
                        <form action="<?= base_url('auth/check') ?>" method="post">
                            <?= csrf_field(); ?>
                            <?php if(!empty(session()->getFlashdata('fail'))){ ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('fail') ?></div>
                            <?php }
                    
                            if(!empty(session()->getFlashdata('success'))){ ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                            <?php } ?>

                            <div class="form-group" style="margin-top: 20px;">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Enter your email" value="<?= set_value('email') ?>">
                                <div class="text-danger"><?= isset($validation)? display_error($validation,'email'):'' ?></div>
                            </div>
                            <div class="form-group" style="margin-top: 20px;">
                                <label for="">Password</label>
                                <input type="text" class="form-control" name="password" placeholder="Enter password" value="<?= set_value('password') ?>">
                                <div class="text-danger"><?= isset($validation)? display_error($validation,'password'):'' ?></div>
                            </div>
                            <div class="form-group d-grid gap-2" style="margin-top: 20px;">
                                <button class="btn btn-primary btn-block" type="submit">Sign In</button>
                            </div>
                            <br>
                            <a href="<?= site_url('auth/register') ?>">Have no account, create new account</a>
                        </form>
                    </div>
                
            </div>
        </div>

    </body>
</html>