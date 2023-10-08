<div class="navbar navbar-inverse navbar-fixed-top navheight">
    <div class="container-fluid">	
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
                <span class="sr-only"> navigation toggle</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand"><img src="images/img_11183.jpg" width="224px" height="25px"></a>
        </div>
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                
                <li style="width:300px;left:10px;top:10px;"><input type="text" class="form-control" id="search"></li>
                <li style="top:10px;left:20px;"><button class="btn btn-primary" id="search_btn">Search</button></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="customer_registration.php?register=1" ><span class="glyphicon glyphicon-user"></span> Register</a></li>	
                <li><a href="customer_registration.php?register=1" ><span class="glyphicon glyphicon-user"></span> Log in</a></li>	
                
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>
                        
                        <ul class="dropdown-menu">
                            <li><a href="logout.php" style="text-decoration:none; color:blue;">Logout</a></li>				
                        </ul>
                    </a>
                    <ul class="dropdown-menu">
                        <div style="width:300px;">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Log In</div>
                                <div class="panel-heading">
                                    <form onsubmit="return false" id="login">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" required/>
                                        <label for="email">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" required/>
                                        <p><br/></p>
                                        <a href="forget_index.php" style="color:white; list-style:none;">Forgotten Password</a><input type="submit" class="btn btn-success" style="float:right;">
                                    </form>
                                </div>
                                <div class="panel-footer" id="e_msg"></div>
                            </div>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<br><br><br><br>