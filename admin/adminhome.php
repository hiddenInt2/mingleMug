<?php
<!DOCTYPE html>
<html>
    <header>
        <link rel="stylesheet" href="adminhome.css">
    </header>
    <body>
        <form action="submit_form.php" method="POST"></form>
        <form>
            <div class="group">
                <div class="Completed">
                    <a href="completedorder.html">
                        <button type="button">Completed Orders</button> 
                    </a>
                </div>

                <div class="Fulfilled">
                    <a href="currentorder.html">
                        <button type="button">Current Orders</button> 
                    </a>
                </div>
                
                <div class="Product">
                    <a href="productManagement.php">
                        <button type="button">Product Management</button>
                    </a>
                </div>

                <div class="Kill">
                    <a href="killSwitch.html">
                        <button type="button">Kill Switch</button>  
                    </a>
                </div>
                <div class="Return">
                    <a href ="../index.html">
                        <button type="button">Return Home</button>
                    </a>
                    
                </div>

                <div class="Logout">
                    <a href="../adminLogin.html">
                        <button type="button">Log Out</button>
                    </a>
                </div>
            </div> 
        </form>
    </body>
</html>
?>