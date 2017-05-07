<!-- MAIN CONTAINER START -->
<div class="container main">
      <div class="col-md-6" id="showcase">
            <p class="lead text-center">Welcome to <span>NetMate</span> - the world's smallest social network</p>
            <img src="images/puzzle.png" alt="Showcase image networking people">
      </div>
      <div class="col-md-6">
            <span id="errorArea"></span>
            <p class="lead text-center">Sign up for free now!</p>
            <form action="" method="POST" class="form-group">
                  <table id="reg">
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">First Name</label>
                                    <input type="text" name="firstName" class="form-control" placeholder="Your First Name" required="true">
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Last Name</label>
                                    <input type="text" name="lastName" class="form-control" placeholder="Your Last Name" required="true">
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email address" required="true">
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Password</label>
                                    <input type="password" name="password" class="form-control password" placeholder="Enter a password" required="true">
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Confirm Password</label>
                                    <input type="password" name="confirmPassword" class="form-control password" placeholder="Confirm password" required="true">
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Select your country</label>
                                    <select name="country" class="form-control" id="countryList">
                                          <option value="#" id="select1">Select your country</option>
                                          <?php include 'includes/countrylist.php'; ?>
                                    </select>
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Select your gender</label>
                                    <select name="gender" id="genderList" class="form-control">
                                          <option value="#" id="select2">Select Your Gender</option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                          <option value="Transgender">Transgender</option>
                                    </select>
                              </td>
                        </tr>
                        
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Your Birthday</label>
                                    <input type="date" name="birthday" class="form-control" required>
                              </td>
                        </tr>

                        <tr>
                              <td>   
                                    <label for="">Type the value you see here:</label><br>
                                    <img class="thumbnail" src="functions/captcha.php">          
                                    <input class="form-control" type="text" size="6" name="secure">
                                    <?php
                                          if (!isset($_POST['secure'])) {
                                                $_SESSION['secure'] = rand(1000, 9999).str_shuffle('cisharp');
                                          }else {
                                                if (!$_SESSION['secure'] == $_POST['secure']) {
                                                      echo "<script>alert('Incorrect. Try again.')</script>";
                                                      $_SESSION['secure'] = rand(1000, 9999).str_shuffle('cisharp');
                                                }
                                          }
                                    ?>
                              </td>
                        </tr>
                        
                        <tr>
                              <td>  
                                    <input type="submit" value="Sign up" name="signup" class="btn btn-primary pull-right">
                              </td>
                        </tr>
                  </table>
            </form>
            <?php require 'includes/insert_user.php'; ?>
      </div>
</div>