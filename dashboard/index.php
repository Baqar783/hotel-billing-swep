<?php
if(!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION['loggedIn'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hotel Billing System</title>
    <script src="../assets/jquery.js"></script>
    <script src="../assets/bootstrap4/popper.js"></script>
    <script src="../assets/bootstrap4/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/bootstrap4/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../assets/custom.css" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-light" style="position: fixed;width:100%; z-index: 999;">
                <a class="navbar-brand text-white" href="#">Hotel Billing System</a>
                <a href="logout.php" class="ml-auto text-white">Logout</a>
                
        </nav>
        <div class="container" style="padding-top: 50px;">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="pill" href="#new_reservation">New Reservation</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#categories">Categories</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#rooms">Rooms</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#reservations">Reservations</a>
                                        </li>

                                    </ul>

                                </div>
                                <div class="toast pt-2 pb-2 text-white" data-delay="3000"  style="position: absolute; top: 150px; right: 0; background-color: #465892; z-index: 99999">
                                        <div class="toast-body" id="toast-body">
                                        </div>
                                </div>
                            </div>
                            
                            <div class="tab-content">
                                    <div id="new_reservation" class="container tab-pane active"><br>
                                        <div class="card">
                                                <div class="card-body">
                                                    <h5>NEW RESERVATION AND BILLING</h5>
                                                    <form id="reservation_form">
                                                        <div class="form-group">
                                                            <label>Surname</label>
                                                            <input type="text" class="form-control" id="lastname" required />
                                                        </div>
        
                                                        <div class="form-group">
                                                                <label>Firstname</label>
                                                                <input type="text" class="form-control" id="firstname" required />
                                                        </div>
                                                        
                                                        <!-- <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="email" class="form-control" id="email" required />
                                                        </div> -->
    
                                                        <div class="form-group">
                                                                <label>Phone</label>
                                                                <input type="tel" class="form-control" id="phone" required />
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                                <label>Category</label>
                                                                <select required class="form-control" id="s_category"></select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                                <label>Room</label>
                                                                <select required class="form-control" id="s_room" multiple></select>

                                                        </div>

                                                        <div class="form-group">
                                                                <label>Number of nights</label>
                                                                <input type="number" class="form-control" id="nights" required />
                                                        </div>
        
                                                        <div class="form-group">
                                                            <button type="submit" class="btn">Save Reservation and Print bill</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                    </div>

                                <div id="categories" class="container tab-pane fade"><br>
                                    <div class="card">
                                        <div class="card-body">
                                            <h5>ADD NEW CATEGORY</h5>
                                            <form id="cat_form">
                                                <div class="form-group">
                                                    <label>Category</label>
                                                    <input type="text" class="form-control" id="new_category" required />
                                                </div>

                                                <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea rows = 4 type="text" class="form-control" id="description" required></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Price per Night</label>
                                                    <input type="number" class="form-control" id="cat_price" required />
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn">Save Category</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="rooms" class="container tab-pane fade"><br>
                                    <div class="card">
                                            <div class="card-body">
                                                <h5>ADD NEW ROOM</h5>
                                                <form id="room_form">
                                                    <div class="form-group">
                                                            <label>Room No.</label>
                                                            <input type="text" class="form-control" id="room" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Category</label>
                                                        <select class="form-control" id="category" required></select>
                                                    </div>
    
                                                    <div class="form-group">
                                                        <button type="submit" class="btn">Save Room</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                </div>
                                <div id="reservations" class="container tab-pane fade"><br>
                                    <div class="card">
                                            <div class="card-body">
                                                <h5>RESERVATIONS</h5>
                                                
                                            </div>
                                        </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    <script>
        let lastname, firstname, phone;
        $(document).ready(function(){
            let _categories;
            $.post('../handler.php',{request: 'get_categories'}, function(data){
                _categories = JSON.parse(data);
                let options = "<option>--select an option--</option>";
                for(c in _categories){
                    options += "<option value='"+_categories[c].category_id+"'>"+_categories[c].category_name+" (N"+ _categories[c].price+")"+"</option>";
                }
                $("#category, #s_category").html(options);
            })
            $('#cat_form').submit(function(e){
                e.preventDefault();
                let category = $('#new_category').val();
                let description = $('#description').val();
                let price = $('#cat_price').val();
                $.post('../handler.php', {category, description, price , request: 'save_category'}, function(data){
                    data = JSON.parse(data);
                    $('.toast').toast('show');
                    $('#toast-body').html(data.message);
                })
            })

            $('#room_form').submit(function(e){
                e.preventDefault();
                let room = $('#room').val();
                let category = $('#category').val();
                $.post('../handler.php', {category, room , request: 'save_room'}, function(data){
                    data = JSON.parse(data);
                    $('.toast').toast('show');
                    $('#toast-body').html(data.message);
                })
            })

            $('#reservation_form').submit(function(e){
                e.preventDefault();
                printBill();
                lastname = $('#lastname').val();
                firstname = $('#firstname').val();
                phone = $('#phone').val();
                let address = $('#address').val();
                let category = $('#s_category').val();
                let room = $('#s_room').val();
                let nights = $('#nights').val();
                $.post('../handler.php', 
                    {
                        lastname,
                        firstname, 
                        phone,  
                        category,
                        room,
                        nights,
                        request: 'save_reservation'}, function(data){
                            data = JSON.parse(data);
                    $('.toast').toast('show');
                    $('#toast-body').html(data.message);
                })
            })

            $('#s_category').change(function(){
                let category_id = $(this).val();
                $.post('../handler.php', { category_id, request: 'get_rooms' }, function(data){
                    let _rooms = JSON.parse(data);
                    let options = "";
                    for(r in _rooms){
                        options += "<option value='"+_rooms[r].room_id+"'>"+_rooms[r].room_name+"</option>";
                    }
                    $("#s_room").html(options);
                    })
            })
        }) 
        
        function printBill(){
                let disp = "";
                let allRooms;
                let room = $('#s_room').val();
                $.post('../handler.php', {request: 'get_all_rooms'}, function(data){
                    let mywindow = window.open('', 'PRINT', 'height=700,width=1000');
                    allRooms = JSON.parse(data);
                    for(let r in room){
                        for(let a in allRooms){
                            if(room[r] == allRooms[a].room_id){
                                disp += `
                                <tr>
                                    <td>${parseInt(a)+1}</td>
                                    <td>room ${allRooms[a].room_name}</td>
                                    <td>${allRooms[a].category_name}</td>
                                    <td>${allRooms[a].description}</td>
                                    <td>${allRooms[a].price}</td>
                                <tr>
                                `;
                            }
                        }
                    }
                mywindow.document.write('<html><head><title>' + document.title + '</title>');
                mywindow.document.write(
                    `<style>
                        *{
                            font-size: 1.1em;
                        }
                        table{
                        border-collapse: collapse;
                        border:solid 3px #777;
                        width:98%;
                        margin: 0 auto;

                    }
                    td,th{
                        border:solid 2px #ccc;
                        padding: 7px 3px;
                    }
                    h5{
                        text-align: center;
                    }
                    </style>`
                );
                mywindow.document.write("</head><body>");
                mywindow.document.write(`
                    <table>
                        <thead>
                        <tr>
                            <th colspan='5'><strong>LAUTECH GUEST HOUSE</strong></th>
                        </tr>
                        <tr>
                            <td>Name:</td><td colspan='2'><strong>${$('#lastname').val()} ${$('#firstname').val()}<strong></td>
                            <td>Phone:</td><td> ${$('#phone').val()} </td>
                        </tr>
                            <tr>
                                <th colspan='5'><strong>BILL DETAILS</strong></th>
                            </tr>
                            <tr>
                                <td>#</td><td><strong>Item</strong></td><td><strong>Category</strong></td><td><strong>Description</strong></td><td><strong>Price</strong></td>
                            </tr>
                            ${disp}
                        </thead>
                        <tbody>`);

                    mywindow.document.write(`
                        </tbody></table></body></html>
                        `);
                        mywindow.document.close(); // necessary for IE >= 10
                        mywindow.focus(); // necessary for IE >= 10*/
                        mywindow.print();
                        mywindow.close();
                    });
                    

        return true;
        }
    </script>
</body>
</html>
<?php
}else{
    header("Location: ../");
}
?>