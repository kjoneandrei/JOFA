<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 text-center">
                        <img src="uploads/<?php echo $_SESSION[USER]->getImgPath(); ?>" alt=""
                             class="center-block img-circle img-responsive profile-picture">
                        <ul class="list-inline ratings text-center" title="Ratings">
                            <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                            <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                            <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                            <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                            <li><a href="#"><span class="fa fa-star fa-lg"></span></a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <h2><?php
                            echo $_SESSION[USER]->getUsername();
                            ?></h2>
                        <p><strong>Email: </strong> <?php
                            echo $_SESSION[USER]->getEmail();
                            ?></p>

                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <form action="?controller=users&action=pictureUpload" method="post"
                              enctype="multipart/form-data">
                            <?php if (isset($_SESSION[TOKEN]))
                            {
                                formToken();
                            } ?>
                            <p>Select new (recommended: 100x100) profile image:</p>
                            <div class="form-group"><input type="file" name="fileToUpload" id="fileToUpload"></div>
                            <div class="form-group"><input type="submit" value="Upload Image" name="submit"></div>
                        </form>
                        <!--/col-->
                    </div>
                </div><!--/row-->
            </div><!--/panel-body-->
        </div><!--/panel-->


    </div>
</div>
