<form role="form" id="reg-form" action="index_json.php" method="POST">
    <div id="logo">
        <img src="./lib/logo.png"/>
    </div>
    <div class="main">
        <h3 class="form-signin-heading">Please sign in</h3>
        <div>After you fill this form, you have to verify your registration via email</div>
        <div class="two">
            <div class="register">

                <?php
                echo $MESSAGE_CONTENT;
                ?>

                <input type="hidden" name="send" value="1"/>
                <input type="email" placeholder="please leave blank this field" name="email" class="focus"/>
                <input type="email" placeholder="mail address" name="to-email" value="do-not@change.me" class="focus"/>

                <div>
                    <label for="inputLogin">Login</label>
                    <input type="text" name="login" autofocus="" tabindex="1" id="inputLogin" value="<?php echo $OLD_CONTENT['login'] ?>">
                </div>
                <div>
                    <label for="inputFirstName">First name</label>
                    <input type="text" name="firstname" tabindex="2" id="inputFirstName" value="<?php echo $OLD_CONTENT['firstname'] ?>">
                </div>
                <div>
                    <label for="inputLastName">Last name</label>
                    <input type="text" name="lastname" tabindex="3" id="inputLastName" value="<?php echo $OLD_CONTENT['lastname'] ?>">
                </div>
                <div>
                    <label for="inputEmail">Email address</label>
                    <input type="text" name="emailaddress" tabindex="4" id="inputEmail" value="<?php echo $OLD_CONTENT['emailaddress'] ?>">
                </div>
                <div>
                    <label for="inputPassword">Password</label>
                    <input type="password" name="password" tabindex="5" id="inputPassword">
                </div>
                <div>
                    <label for="inputReenterPassword">Reenter Password</label>
                    <input type="password" name="reenter_password" tabindex="6" id="inputReenterPassword">
                </div>
                <div class="g-recaptcha" data-sitekey="6LcTcj8UAAAAAOgeonaqGTEU-SbD7sjI7q4nwtKy"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="submit">
        <input type="submit" id="create-account" class="button" value ="Sign in" tabindex="7"/>
    </div>
</form>