<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 text-center">
                        <img src="http://api.randomuser.me/portraits/men/49.jpg" alt=""
                             class="center-block img-circle img-responsive">
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
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            Select new profile image:
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Upload Image" name="submit">
                        </form>
                  

                    <!--/col-->
                    </div>
                </div><!--/row-->
            </div><!--/panel-body-->
        </div><!--/panel-->


    </div>
</div>
