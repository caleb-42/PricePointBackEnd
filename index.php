<?php require_once "assets/php/includes/start_session.php" ;
require_once "assets/php/includes/functions.php";
confirm_logged_in();
require_once "assets/php/myphp-backup-master/myphp-backup.php";?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>PricePoint Control Panel</title>


        <!-- jQuery core -->
        <script src="./vendors/jquery/jquery-3.1.1.min.js"></script>

        <!-- jQueryui core -->
        <link rel="stylesheet" href="./vendors/jquery-ui-1.12.1/jquery-ui.css">
        <script src="./vendors/jquery-ui-1.12.1/jquery-ui.js"></script>

        <!-- Bootstrap core-->
        <link rel="stylesheet" href="./vendors/bootstrap4-alpha/css/bootstrap.min.css">
        <link rel="stylesheet" href="./vendors/font-awesome-4.7.0/css/font-awesome.min.css">
        <script src="./vendors/bootstrap4-alpha/js/bootstrap.min.js"></script>

        <!-- dybnatable core-->
        <link rel="stylesheet" href="./vendors/jspkg-archive/jquery.dynatable.css">
        <script src="./vendors/jspkg-archive/jquery.dynatable.js"></script>

        <!-- Hamburger css -->
        <link href="./vendors/hamburgers/dist/hamburgers.css" rel="stylesheet">

        <!-- list core js -->
        <script src="./vendors/List/List.js"></script>

        <!-- Custom styles for this template -->
        <link href="./assets/css/index.css" rel="stylesheet">
        <script src="./assets/js/index.js"></script>
    </head>

    <body onload="">

        <div div id="wrapper" class="toggled">

            <div id="sidebar" class="">
                <div class="d-inline-flex d-flex float-right float-sm-left">
                    <p id="dataToggler" class="mx-sm-3 my-sm-4 mr-5 mt-3 p-sm-1 hamburger hamburger--arrowturn is-active"><a href="#"><span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                        </span></a></p>
                </div>
                <div class="" id="mynav">
                    <div id="navmenu" class="w-100 mt-sm-4 d-inline-flex flex-column">
                        <a id="dashboard" class="mb-sm-4 active d-flex" href="#dash">
                            <img src="./assets/img/dashicon-01.png">
                            <span class="ml-3 my-auto menunames">Dashboard</span>
                        </a>
                        <a id="products" class="mb-sm-4 d-flex" href="#prod" data-str="products" data-act = "select_operation">
                            <img src="./assets/img/products_icon.png">
                            <span class="ml-3 my-auto menunames">Products</span>
                        </a>
                        <a id="user" class="mb-sm-4 d-flex" href="#usr" data-str="users" data-act="select_operation">
                            <img src="./assets/img/user_icon.png">
                            <span class="ml-3 my-auto menunames">Users</span>
                        </a>
                        <a id="customers" class="mb-sm-4 d-flex" href="#cust" data-str="customers" data-act="select_operation">
                            <img src="./assets/img/customer_icon.png">
                            <span class="ml-3 my-auto menunames">Customers</span>
                        </a>
                        <a onclick='$("#sales-stock").html() == "Stock" ? $("#sales-stock").trigger("click") : "Sales";$("#sales-stock").html() == "Invoice Updates" ? $("#sales-stock").trigger("click") : "Sales";' id="records" class="mb-sm-4 d-flex" href="#rec" data-str="customerinvoice" data-act="select_operation">
                            <img src="./assets/img/record_icon.png">
                            <span class="ml-3 my-auto menunames">Records</span>
                        </a>
                        <a id="logout" class="mb-sm-4 d-flex" href="assets/php/logout.php">
                            <img src="./assets/img/logicon-01.png">
                            <span class="ml-3 my-auto menunames">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="main" class="container-fluid nopadding">
                <nav class="navbar py-3 px-sm-4 d-flex flex-row justify-content-between boxshod" >
                    <div class="d-inline-flex d-flex float-right float-sm-left">
                        <!--p id="dataToggler" class="m-sm-1 mr-1 mt-1 p-sm-1"><a href="#"><i style="color:#222; transform: scale(1.3,1); opacity:.7;" class="fa fa-arrow-left fa-2x"></i></a></p-->
                        <h1 class="ml-sm-4 align-self-center" style="font-size: 1.8rem; font-weight:600;" href="#">PricePoint Pharmacy Admin</h1>
                    </div>

                    <div class="row mr-5">
                        <img class="rounded-circle mr-2 align-self-center" src="assets/img/avatar.png">
                        <h6 class="align-self-center font-weight-bold adminref"><?php echo $_SESSION['username']; ?></h6>
                        <a id="logout" href="assets/php/logout.php"><button class = "btn ml-4 btn-purp">
                            Log out
                            </button></a>
                    </div>
                </nav>
                <div class="" id="tabs">

                    <!--...............@ewereB.................-->
                    <div id="dash" class="w-100 tab visible text-center row" style="margin: 120px auto;">
                        <img  class = "mx-auto" style = "width:600px !important; height:280px !important;opacity:.1" src = "assets/img/logo.png"/>
                    </div>
                    <div id="prod" class="tab notvisible">
                        <div class="tabdock float-left">
                            <div id="product-list" class="mb-5">
                                <div class = "mang">
                                    <h4>Manage Products</h4>
                                    <input class="search" placeholder="Search" id = "productsearch"  onfocus = "refreshpage()"/>
                                    <div class="row justify-content-between my-3 crudhd">
                                        <button class="btn btn-success btn-md btn-pill"  data-toggle = "modal" data-target = "#addProduct">Add Product</button>
                                        <button class="btn btn-warning btn-md btn-pill" onclick="deleteProduct();">Delete Product</button>
                                        <button class="btn btn-primary btn-md btn-pill deactivate updateprodbtn"  data-toggle = "modal" data-target = "#updateProduct" onclick="updateProduct('load');">Update Product</button>
                                    </div>
                                    <div class="row mt-3 w-100 py-2" style="margin:0; background:#2499BC; color:#fff; padding: 0px 14px;">
                                        <div class="sort div-pill" data-sort="product_name">
                                            Name
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="product_description">
                                            description
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="stock">
                                            Stock
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="product_retailprice">
                                            Retail price
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="product_wholesaleprice">
                                            Wholesale price
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="expiry_date">
                                            Closest expiry date
                                        </div>
                                    </div>
                                </div>
                                <ul class="list">
                                </ul>
                            </div>
                        </div>
                        <div class="history float-right">
                            <div id="producthistorypane" class="tabdockpane">
                                <div class="stocknodisp nodisp">
                                    <h3>Select a Product</h3>
                                </div>
                                <div class="stockdisp disp">
                                    <div class="tab1 table-responsive" style="overflow-x: hidden;">
                                        <table class="table table-striped table-bordered table-sm" width="100%" id="stocktable">
                                            <div class="histmang">
                                                <col width="30%">
                                                <col width="15%">
                                                <col width="15%">
                                                <col width="20%">
                                                <col width="30%">
                                                <h3 class ="prodname tabpaneTitle" onclick="togglehisttab('stockdisp')"></h3>
                                                <div class="crudhd row my-3 d-flex flex-column">
                                                    <input class="form-control w-100 mb-2 text-center" onkeyup="tablefilter($(this), 'stocktable');" placeholder="Search" id = "stocksearch"/>
                                                    <button class="btn btn-secondary btn-sm btn-pill mb-1"  data-toggle = "modal" data-target = "#addStock" onclick="modaltitlechg('#addStock .modal-title','li.actparent .product_name')">Add Stock</button>
                                                    <button class="btn btn-secondary btn-sm btn-pill mb-1" onclick="deleteStock();">Delete Stock</button>
                                                </div>
                                                <thead class="mt-5">
                                                    <tr>
                                                        <th style="text-align: center;">EXP DATE</th>
                                                        <th style="text-align: center;">STK BOUGHT</th>
                                                        <th style="text-align: center;">STK SOLD</th>
                                                        <th style="text-align: center;">STK LEFT</th>
                                                        <th style="text-align: center;">ENTRY DATE</th>
                                                    </tr>
                                                </thead>
                                            </div>
                                            <tbody id="prodlist" class="tabtable">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab2 table-responsive" style="display:none;overflow-x: hidden;">
                                        <table class="table table-striped table-bordered table-sm" width="100%" id="stockentrytable">
                                            <div class="histmang">
                                                <col width="40%">
                                                <col width="20%">
                                                <col width="40%">
                                                <h3 class ="prodname tabpaneTitle" onclick="togglehisttab('stockdisp')"></h3>
                                                <div class="paneinfo">
                                                    <div class = "row justify-content-between mb-1"><span>Expiry Date</span> <span class="expdt">ds</span></div>
                                                    <div class = "row justify-content-between mb-1"><span>Bought Stock</span> <span class="totstk ">sd</span></div>
                                                    <div class = "row justify-content-between mb-1"><span>Sold Stock</span> <span class="sldstk ">sd</span></div>
                                                    <div class = "row justify-content-between mb-1"><span>Left Stock</span> <span class="lftstk ">sd</span></div>
                                                </div>

                                                <div class="row my-3 d-flex flex-column crudhd">
                                                    <input class="form-control w-100 mb-2 text-center" onkeyup="tablefilter($(this), 'stockentrytable');" placeholder="Search" id = "stockentrysearch"/>

                                                    <button class="btn btn-secondary btn-sm btn-pill mb-1 deactivate"  data-toggle = "modal" data-target = "#updateStock" onclick="updateStock('load');">Update Stock Entry</button>
                                                    <button class="btn del btn-secondary btn-sm btn-pill mb-1 deactivate" onclick="deleteStockentry();">Delete Stock Entry</button>
                                                </div>
                                                <thead class="mt-5">
                                                    <tr>
                                                        <th style="text-align: center;">ENTRY DATE</th>
                                                        <th style="text-align: center;">STK QTY</th>
                                                        <th style="text-align: center;">BY ADMIN</th>
                                                    </tr>
                                                </thead>
                                            </div>
                                            <tbody id="prodlistdetails" class="tabtable stktb">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="usr" class="tab notvisible">
                        <div class="tabdock float-left w-50">
                            <div id="account-list" class="">
                                <div class = "mang">
                                    <h4>Manage Users</h4>
                                    <input class="search" placeholder="Search" id = "accountsearch"/>
                                    <div class="crudhd row justify-content-between my-3">
                                        <button class="btn btn-success btn-md btn-pill "  data-toggle = "modal" data-target = "#addUseraccount">Add User</button>
                                        <button class="btn btn-warning btn-md btn-pill" onclick="deleteUseraccount();">Delete User</button>
                                    </div>
                                    <div class="row mt-3 w-100 py-2" style="margin:0; background:#D32F53; color:#fff;">
                                        <div class="sort div-pill col-6" data-sort="username">
                                            Name
                                        </div>
                                        <div class="sort div-pill col-6 text-center" data-sort="category">
                                            Category
                                        </div>
                                    </div>
                                </div>
                                <ul class="list">
                                </ul>
                            </div>
                        </div>
                        <div class="history float-right w-50">
                            <div id="userhistorypane" class="tabdockpane">
                                <div class="accnodisp nodisp">
                                    <h3>Select an Account</h3>
                                </div>
                                <div class="accdisp disp">
                                    <h3 class ="usrnam"></h3>
                                    <div class="table-responsive mt-4">
                                        <table class="table table-striped table-bordered table-sm" width="100%">
                                            <col width="25%">
                                            <col width="25%">
                                            <col width="25%">
                                            <col width="25%">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">USERNAME</th>
                                                    <th style="text-align: center;">LOG ON</th>
                                                    <th style="text-align: center;">LOG OFF</th>
                                                    <th style="text-align: center;">DURATION</th>
                                                </tr>
                                            </thead>
                                            <tbody id="userlist" class="tabtable">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="cust" class="tab notvisible">
                        <div class="tabdock float-left">
                            <div id="customer-list" class="centercoldiv mb-5">
                                <div class = "mang">
                                    <h4>Manage Customer</h4>
                                    <input class="search" placeholder="Search" id = "customersearch" onfocus = "refreshpage()"/>
                                    <div class="row justify-content-between my-3 crudhd">
                                        <button class="btn btn-success btn-md btn-pill"  data-toggle = "modal" data-target = "#addcustomer">Add Customer</button>
                                        <button class="btn btn-warning btn-md btn-pill" onclick="deletecustomer();">Delete Customer</button>
                                        <button class="btn btn-primary btn-md btn-pill deactivate updatecustbtn"  data-toggle = "modal" data-target = "#updatecustomer" onclick="updatecustomer('load');">Update Customer</button>
                                    </div>
                                    <div class="row mt-3 w-100 py-2" style="margin:0; background:#25A54C; color:#fff; padding: 0px 14px;">
                                        <div class="sort div-pill" data-sort="customer_name">
                                            Name
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="last_visit">
                                            last visit
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="visit_count">
                                            visit count
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="outstanding_balance">
                                            Outstanding balance
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="customer_phone">
                                            Phone
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="customer_email">
                                            Email
                                        </div>
                                        <div class="sort div-pill text-center" data-sort="address">
                                            Address
                                        </div>
                                    </div>
                                </div>
                                <ul class="list">
                                </ul>
                            </div>
                        </div>
                        <div class="history float-right">
                            <div id="customerhistorypane" class="tabdockpane">
                                <div class="inventorynodisp nodisp">
                                    <h3>Select a Customer</h3>
                                </div>
                                <div class="inventorydisp disp">

                                    <div class="tab1 table-responsive" style="overflow-x: hidden;">
                                        <table class="table table-striped table-bordered table-sm" width="100%" id="customertable">
                                            <div class="histmang">
                                                <col width="30%">
                                                <col width="20%">
                                                <col width="20%">
                                                <col width="20%">
                                                <h3 class ="customername tabpaneTitle"></h3>
                                                <div class="crudhd row my-3 d-flex flex-column">
                                                    <input class="form-control w-100 mb-2 text-center" onkeyup="tablefilter($(this), 'customertable');" placeholder="Search" id = "custsearch"/>
                                                    
                                                    <button class="float-left btn btn-secondary btn-sm btn-pill mb-1"  data-toggle = "modal" data-target = "#debtpayment" onclick="debtpayment('load');">Debt payment</button>
                                                    <button class="float-right btn btn-secondary btn-sm btn-pill mb-1"  data-toggle = "modal" onclick="deletedebtpayment();">Delete Debt payment</button>
                                                </div>

                                                <thead class="mt-5">
                                                    <tr>
                                                        <th style="text-align: center;">DATE</th>
                                                        <th style="text-align: center;">INV NO</th>
                                                        <th style="text-align: center;">TOTAL</th>
                                                        <th style="text-align: center;">PAID</th>
                                                        <th style="text-align: center;">OUT BAL</th>
                                                    </tr>
                                                </thead>
                                            </div>
                                            <tbody id="inventorylist" class="tabtable cust_invtb">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab2 table-responsive" style="display:none;
                                                                              overflow-x: hidden;">
                                        <table class="table table-striped table-bordered table-sm" width="100%" id="customerdetailstable">
                                            <div class="histmang">
                                                <col width="40%">
                                                <col width="20%">
                                                <col width="20%">
                                                <col width="20%">
                                                <h3 class ="customername tabpaneTitle" onclick="togglehisttab('inventorydisp')"></h3>
                                                <div class="paneinfo">
                                                    <div class = "row justify-content-between mb-1"><span>Total Amount</span> <span class="Totalamtbt">ds</span></div>
                                                    <div class = "row justify-content-between mb-1"><span>Total Spent</span> <span class="Totalspent">ds</span></div>
                                                    <div class = "row justify-content-between mb-1"><span>Sales Ref</span> <span class="salesreff ">sd</span></div>
                                                    <div class = "row justify-content-between mb-1"><span>Invoice No</span> <span class="invnum">sd</span></div>
                                                    <div class = "row justify-content-between mb-1"><span>Date</span> <span class="datesale">sd</span></div>
                                                    
                                                </div>
                                                <div class = "row justify-content-around">
                                                <button class="btn btn-secondary btn-sm btn-pill mb-3 text-center" style = "width:45%;"  data-toggle = "modal" data-target = "#addCustomerInventory" onclick="addToInvoicePrimer();">Add Product</button>
                                                <button class="btn btn-secondary btn-sm btn-pill mb-3 text-center" style = "width:45%;" onclick="deleteInventoryentry();">Delete Product</button>
                                                </div>
                                                <thead class="mt-5">
                                                    <tr>
                                                        <th style="text-align: center;">PRODUCTS</th>
                                                        <th style="text-align: center;">QTY</th>
                                                        <th style="text-align: center;">AMT</th>
                                                        <th style="text-align: center;">TYPE</th>
                                                    </tr>
                                                </thead>
                                            </div>
                                            <tbody id="inventorylistdetails" class="tabtable cust_invdetails_tb">

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="rec" class="tab notvisible">
                        <div class="tabdock">
                            <div id="sales-list" class="centercoldiv mb-5">
                                <div class = "mang">
                                    <h4>Manage sales and stocks</h4>
                                    <div class="row justify-content-around">
                                        <input class="search w-25" placeholder="Search" id = "salessearch" onfocus="$(this).val(''); mylist.search();"/>
                                        <button id="sales-stock" type="button" class="btn btn-dang px-4" style="font-weight:600;" onclick="$('#salessearch').val(''); if($(this).text() == 'Stock'){$(this).text('Sales').css('background','#d9534f');}else if($(this).text() == 'Sales'){$(this).text('Stock').css('background','#f0ad4e');}else if($(this).text() == 'Invoice Updates'){$(this).text('Sales').css('background','#A644E0');} getdata($(this));">Sales</button>
                                        <input id="startdate" type="text" name="frodate" placeholder="start date" class = "inpdate sdate"/>
                                        <input id="enddate" type="text" name="frodate" placeholder="end date" class = "inpdate sdate"/>
                                        <button id="" type="button" style="font-weight:600;" class="btn px-4 btn-primary btn-md" onclick="getdata($(this));">GET</button>
                                        <button class = "btn btn-success align-self-center px-4" style="font-weight:600;" data-toggle = "modal" data-target = "#print" type="button" id="printbtn"  onclick="printtab();"><i class="fa fa-print"></i>
                                            PRINT
                                        </button>
                                    </div>
                                    <div class = "moneyrep w-100 text-center my-4 mx-3" style="font-family: font-family: 'verdana', sans-serif; margin-left: 0 !important;">
                                        <div class = "row justify-content-between firstrow w-100 mb-4" style="margin: auto 0;"><div class = "" style=""><h6 style="display:inline;color:#333;text-align:center;">ENTRIES</h6><h6 id = "entryno" style="font-weight:bold;display:inline;color:#333;text-align:center;margin-left:10px;"></h6></div><div class = "moneyinfo" style=""><h6 style="display:inline;color:#333;text-align:center;">TOTAL COST</h6><h6 id = "totcost" style="font-weight:bold;display:inline;color:#333;text-align:center;margin-left:10px;"></h6></div><div class = "moneyinfo" style=""><h6 style="display:inline;color:#333;text-align:center;">TOTAL PAID</h6><h6 id = "totpaid" style="font-weight:bold;display:inline;color:#333;text-align:center;margin-left:10px;"></h6></div><div class = "moneyinfo outbal" style=""><h6 style="display:inline;color:#333;text-align:center;">OUT BAL</h6><h6 id = "totoutbal" style="font-weight:bold;display:inline;color:#333;text-align:center;margin-left:10px;"></h6></div>
                                        </div>
                                        <div class="row justify-content-between secrow w-100 " style="margin: auto 0;"><div class = "moneyinfo" style=""><h6 style="display:inline;color:#333;text-align:center;">POS</h6><h6 id = "pos" style="font-weight:bold;display:inline;color:#333;text-align:center;margin-left:10px;"></h6></div><div class = "moneyinfo" style=""><h6 style="display:inline;color:#333;text-align:center;">CHEQUE</h6><h6 id = "cheque" style="font-weight:bold;display:inline;color:#333;text-align:center;margin-left:10px;"></h6></div><div class = "moneyinfo" style=""><h6 style="display:inline;color:#333;text-align:center;">CASH</h6><h6 id = "cash" style="font-weight:bold;display:inline;color:#333;text-align:center;margin-left:10px;"></h6></div><div class = "moneyinfo" style=""><h6 style="display:inline;color:#333;text-align:center;">CREDIT</h6><h6 id = "credit" style="font-weight:bold;display:inline;color:#333;text-align:center;margin-left:10px;"></h6></div></div></div>

                                    <div class="invtable mt-4">
                                        <div class="row w-100 py-2 saleshd rechd onact" style="margin:0; font-weight:600; background:#704D30; color:#fff; padding: 0px 14px;">
                                            <div class="sort div-pill" data-sort="date">
                                                Sales date
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="date">
                                                Buyer
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="invno">
                                                Invoice no
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="totalamt">
                                                Total cost
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="totalpaid">
                                                Total paid
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="outbalance">
                                                out bal
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="category">
                                                Status
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="salesref">
                                                Sales ref
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="paymeth">
                                                method
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-4 w-100 py-2 stockhd rechd notvisible" style="margin:0; font-weight:600; background:#704D30; color:#fff; padding: 0px 14px;">
                                            <div class="sort div-pill" data-sort="entry_date">
                                                Entry date
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="productname">
                                                Product
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="stockbought">
                                                Stock bought
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="stocksold">
                                                Stock sold
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="stockremain">
                                                Stock remain
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="entries">
                                                Entries
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="expirydate">
                                                Expiry date
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-4 w-100 py-2 invupdatehd rechd notvisible" style="margin:0; font-weight:600; background:#704D30; color:#fff; padding: 0px 14px;">
                                            <div class="sort div-pill" data-sort="entry_date">
                                                customer
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="productname">
                                                invoice
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="stockbought">
                                                date of update
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="expirydate">
                                                total bought
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="stockremain">
                                                money paid
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="stocksold">
                                                old payment
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="stockremain">
                                                new payment
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="entries">
                                                old outbal
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="expirydate">
                                                new outbal
                                            </div>
                                            <div class="sort div-pill text-center" data-sort="entries">
                                                updated by
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <ul class="list">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--...............@ewereS.................-->

                </div>
                <!--</div>-->
            </div>
            <div>
            </div>
        </div>
        
        <div class="modal fade" id="addStock" class = "add_operation" role="dialog" >
            <div class="modal-dialog modal-md">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Add Stock</h5>
                        <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">�</button>
                    </div>
                    <div class="modal-body nopadding">

                        <form autocomplete="off" role="form" method="get" id="addStock_form" class="">
                            <div class="mx-5 my-5 px-5">
                                <div class="padd mx-auto">
                                    <label class="text-primary inputtext w-100">Entry Date</label>
                                    <input type="text" name="entry_date" class="form-control inputadjust textadjust sdate">
                                    <label class="text-primary inputtext w-100 mt-3">Stock Quantity</label>
                                    <input type="Number" name="stockno" class="form-control text-center textadjust">
                                    <label class="text-primary inputtext w-100 mt-3">Expiry Date</label>
                                    <input type="text" name="stockexpiry_date" class="form-control inputadjust textadjust expstkdate exp ">
                                </div>
                            </div>
                        </form>

                        <div class="modal-footer w-100">
                            <div class="justify-content-center w-100 d-flex flex-column" style="height:50px;">
                                <div class="py-3 align-self-center">

                                    <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                    <button type="button" class="btn btn-success btnmod" onclick="addStock($('#addStock .modal-title').html(), '<?php echo $_SESSION['username']; ?>');">
                                        CREATE
                                    </button>
                                </div>
                                <p class = "outputmod align-self-center" style="width:50%; font-size:15px;  text-align:center;z-index:10; font-weight: 600; opacity:0;"></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="addcustomer" class = "add_operation" role="dialog" >
            <div class="modal-dialog modal-md">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Create Customer</h5>
                        <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">�</button>
                    </div>
                    <div class="modal-body nopadding">

                        <form role="form" method="get" id="customer_form" class="">
                            <div class="mx-5 my-5 px-5">
                                <div class="padd mx-auto">
                                    <label class="text-primary inputtext w-100">Name</label>
                                    <input type="text" name="customer_name" class="form-control inputadjust textadjust">
                                    <label class="text-primary inputtext w-100 mt-3">Email</label>
                                    <input type="text" name="customer_email" class="form-control text-center textadjust">
                                </div>
                                <div class="padd mx-auto mt-3">
                                    <label class="text-primary inputtext w-100">Phone Number</label>
                                    <input type="Number" name="customer_phone" class="form-control inputadjust textadjust">
                                    <label class="text-primary inputtext w-100 mt-3">Address</label>
                                    <textarea rows=2 type="text" name="address" class="textadjust form-control text-center"></textarea>
                                </div>
                            </div>
                        </form>

                        <div class="modal-footer w-100">
                            <div class="justify-content-center w-100 d-flex flex-column">
                                <div class="py-3 align-self-center">

                                    <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                    <button type="button" class="btn btn-success btnmod" onclick="addcustomer($(this));">
                                        CREATE
                                    </button>
                                </div>
                                <p class = "outputmod align-self-center" style="width:50%; font-size:15px;  text-align:center;font-weight: 600; opacity:0;"></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addProduct" class = "add_operation" role="dialog" >
            <div class="modal-dialog modal-md">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Create New Product</h5>
                        <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">x</button>
                    </div>
                    <div class="modal-body nopadding">

                        <form role="form" method="get" id="product_form" class="">
                            <div class="mx-5 my-5 px-5">
                                <div class="padd mx-auto">
                                    <label class="text-primary inputtext w-100">Name</label>
                                    <input type="text" name="product_name" class="form-control inputadjust textadjust">
                                    <label class="text-primary inputtext w-100 mt-3">Description</label>
                                    <textarea rows=2 type="text" name="product_description" class="textadjust form-control text-center"></textarea>
                                </div>
                                <div class="padd mx-auto mt-3">
                                    <label class="text-primary inputtext w-100">Retail Price</label>
                                    <input type="number" name="product_retailprice" class="form-control inputadjust textadjust">
                                    <label class="text-primary inputtext w-100 mt-3">Wholesale Price</label>
                                    <input type="number" name="product_wholesaleprice" class="form-control inputadjust textadjust">
                                </div>
                            </div>
                        </form>

                        <div class="modal-footer w-100">
                            <div class="justify-content-center w-100 d-flex flex-column">
                                <div class="py-3 align-self-center">

                                    <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                    <button type="button" class="btn btn-success btnmod" onclick="addProduct($(this));">
                                        CREATE
                                    </button>
                                </div>
                                <p class = "outputmod align-self-center" style="width:50%; font-size:15px;  text-align:center;font-weight: 600; opacity:0;"></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addUseraccount" role="dialog" >
            <div class="modal-dialog modal-md">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Create New User</h5>
                        <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">�</button>
                    </div>
                    <div class="modal-body nopadding">

                        <form role="form" method="post" id="user_form">
                            <div class="mx-3 my-5">
                                <div class="padd w-50 mx-auto">
                                    <label class="text-primary inputtext w-100">Username</label>
                                    <input type="text" name="username" class="form-control inputadjust textadjust">
                                </div>
                                <div class="padd w-50 mx-auto mt-4">
                                    <label class="text-primary inputtext w-100">Password</label>
                                    <input type="password" name="password" class="form-control inputadjust textadjust">
                                </div>
                                <div class="w-50 mx-auto px-4 my-5">
                                    <span class="float-left">
                                        <label for="admin" class=" mr-2">Admin</label>
                                        <input value="admin" type="radio" name="cat" class="" id="admin"/>
                                    </span>
                                    <span class="float-right">
                                        <label for="user" class=" mr-2">User</label>
                                        <input value = "user" type="radio" name="cat" class="" id="user"/>
                                    </span>


                                </div>
                            </div>
                        </form>

                        <div class="modal-footer w-100 mt-5">
                            <div class="justify-content-center w-100 d-flex flex-column">
                                <div class="py-3 align-self-center">

                                    <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                    <button type="button" class="btn btn-success " onclick="addUseraccount($(this));" id="btnadduser">
                                        CREATE
                                    </button>
                                </div>
                                <p id = "adduseroutput" class="align-self-center" style="width:50%; font-size:15px;  text-align:center;font-weight: 600; opacity:0;"></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateStock" class = "update_operation" role="dialog" >
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Update Stock</h5>
                        <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">�</button>
                    </div>
                    <div class="modal-body nopadding">

                        <form role="form" method="get" id="updstock_form" class="">
                            <div class="ml-5 my-5 float-left" style="width:40%">
                                <div class="padd">
                                    <label class="text-primary inputtext w-100">Entry Date</label>
                                    <input type="text" name="entrdate" class="form-control inputadjust textadjust" readonly>
                                    <label class="text-primary inputtext w-100 mt-3">Stock Quantity</label>
                                    <input type="Number" name="stocno" class="form-control text-center textadjust" readonly>
                                </div>
                            </div>
                            <div class="mr-5 my-5  float-right" style="width:40%">
                                <div class="padd">
                                    <label class="text-primary inputtext w-100">Entry Date</label>
                                    <input type="text" name="entry_date" class="form-control inputadjust textadjust sdate">
                                    <label class="text-primary inputtext w-100 mt-3">Stock Quantity</label>
                                    <input type="Number" name="stockno" class="form-control text-center textadjust">
                                </div>
                            </div>
                        </form>

                        <div class="modal-footer w-100">
                            <div class="justify-content-center w-100 d-flex flex-column">
                                <div class="py-3 align-self-center">

                                    <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                    <button type="button" class="btn btn-success btnmod" onclick="updateStock('store');">
                                        UPDATE
                                    </button>
                                </div>
                                <p class = "outputmod align-self-center" style="width:50%; font-size:15px;  text-align:center;font-weight: 600; opacity:0;"></p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="updatecustomer" class = "update_operation" role="dialog" >
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Update Customer</h5>
                        <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">�</button>
                    </div>
                    <div class="modal-body nopadding">

                        <form role="form" method="get" id="updcustomer_form" class="">
                            <div class="ml-5 my-5 float-left" style="width:40%">
                                <div class="padd mx-auto">
                                    <label class="text-primary inputtext w-100">Name</label>
                                    <input type="text" name="cust_name" class="form-control inputadjust textadjust" readonly>
                                    <label class="text-primary inputtext w-100 mt-3">Email</label>
                                    <input type="text" name="cust_email" class="form-control text-center textadjust" readonly>
                                </div>
                                <div class="padd mx-auto mt-3">
                                    <label class="text-primary inputtext w-100">Phone Number</label>
                                    <input type="Number" name="cust_phone" class="form-control inputadjust textadjust" readonly>
                                    <label class="text-primary inputtext w-100 mt-3">Address</label>
                                    <textarea rows=2 type="text" name="cust_address" class="form-control text-center textadjust" readonly></textarea>
                                </div>
                            </div>
                            <div class="mr-5 my-5  float-right" style="width:40%">
                                <div class="padd mx-auto">
                                    <label class="text-primary inputtext w-100">Name</label>
                                    <input type="text" name="customer_name" class="form-control inputadjust textadjust">
                                    <label class="text-primary inputtext w-100 mt-3">Email</label>
                                    <input type="text" name="customer_email" class="form-control text-center textadjust">
                                </div>
                                <div class="padd mx-auto mt-3">
                                    <label class="text-primary inputtext w-100">Phone Number</label>
                                    <input type="Number" name="customer_phone" class="form-control inputadjust textadjust">
                                    <label class="text-primary inputtext w-100 mt-3">Address</label>
                                    <textarea rows=2 type="text" name="address" class="textadjust form-control text-center"></textarea>
                                </div>
                            </div>
                        </form>

                        <div class="modal-footer w-100">
                            <div class="justify-content-center w-100 d-flex flex-column">
                                <div class="py-3 align-self-center">

                                    <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                    <button type="button" class="btn btn-success btnmod" onclick="updatecustomer('store');">
                                        UPDATE
                                    </button>
                                </div>
                                <p class = "outputmod align-self-center" style="width:50%; font-size:15px;  text-align:center;font-weight: 600; opacity:0;"></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="updateProduct" class = "update_operation" role="dialog" >
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Update Product</h5>
                        <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">�</button>
                    </div>
                    <div class="modal-body nopadding">

                        <form role="form" method="get" id="updproduct_form" class="">
                            <div class="ml-5 my-5 float-left" style="width:40%">
                                <div class="padd">
                                    <!-- <label class="text-primary inputtext w-100">Name</label>
                                    <input type="text" name="proname" class="form-control inputadjust textadjust" readonly> -->
                                    <label class="text-primary inputtext w-100 mt-3">Description</label>
                                    <textarea rows=2 type="text" name="proddescription" class="form-control text-center textadjust" readonly></textarea>
                                </div>
                                <div class="padd pt-3">
                                    <label class="text-primary inputtext w-100">Retail Price</label>
                                    <input type="number" name="prodretailprice" class="form-control inputadjust textadjust" readonly>
                                    <label class="text-primary inputtext w-100 mt-3">Wholesale Price</label>
                                    <input type="number" name="prodwholesaleprice" class="form-control inputadjust textadjust" readonly>
                                </div>
                            </div>
                            <div class="mr-5 my-5  float-right" style="width:40%">
                                <div class="padd">
                                    <!-- <label class="text-primary inputtext w-100">Name</label>
                                    <input type="text" name="product_name" class="form-control inputadjust textadjust"> -->
                                    <label class="text-primary inputtext w-100 mt-3">Description</label>
                                    <textarea rows=2 type="text" name="product_description" class="textadjust form-control text-center"></textarea>
                                </div>
                                <div class="padd pt-3">
                                    <label class="text-primary inputtext w-100">Retail Price</label>
                                    <input type="number" name="product_retailprice" class="form-control inputadjust textadjust">
                                    <label class="text-primary inputtext w-100 mt-3">Wholesale Price</label>
                                    <input type="number" name="product_wholesaleprice" class="form-control inputadjust textadjust">
                                </div>
                            </div>
                        </form>

                        <div class="modal-footer w-100">
                            <div class="justify-content-center w-100 d-flex flex-column">
                                <div class="py-3 align-self-center">

                                    <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                    <button type="button" class="btn btn-success btnmod" onclick="updateProduct('store');">
                                        UPDATE
                                    </button>
                                </div>
                                <p class = "outputmod align-self-center" style="width:50%; font-size:15px;  text-align:center;font-weight: 600; opacity:0;"></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="debtpayment" class = "update_operation" role="dialog" >
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Debt Payment</h5>
                        <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">�</button>
                    </div>
                    <div class="modal-body nopadding">

                        <form role="form" method="get" id="debtpayment_form" class="">
                            <div class="ml-5 my-5 float-left" style="width:40%">
                                <div class="padd">
                                    <label class="text-primary inputtext w-100 mt-3">debt</label>
                                    <input type="number" name="debt_read" class="form-control inputadjust textadjust" readonly>
                                </div>
                            </div>
                            <div class="mr-5 my-5  float-right" style="width:40%">
                                <div class="padd">
                                    <label class="text-primary inputtext w-100 mt-3">Money paid now</label>
                                    <input type="number" name="paidamt" class="form-control inputadjust textadjust">
                                </div>
                            </div>
                            <div class="padd mt-3 invoicepaymeth">
                                <select onchange = "selchang($(this))" class="form-control methpay mx-auto my-4"  name="paymethod" style="font-size:12px;width:40%;"><option value="Cash">Cash</option><option value="Cheque">Cheque</option><option value="POS">POS</option><option value="Credit">Credit</option></select>
                            </div>
                        </form>

                        <div class="modal-footer w-100">
                            <div class="justify-content-center w-100 d-flex flex-column">
                                <div class="py-3 align-self-center">

                                    <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                    <button type="button" class="btn btn-success btnmod" onclick="debtpayment('store');">
                                        UPDATE
                                    </button>
                                </div>
                                <p class = "outputmod align-self-center" style="width:50%; font-size:15px;  text-align:center;font-weight: 600; opacity:0;"></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="modal fade" id="updateCustomerInventory" class = "update_operation" role="dialog" >
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Update Inventory</h5>
                        <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">x</button>
                    </div>
                    <div class="modal-body nopadding">

                        <form role="form" method="get" id="updateCustomerInventory_form" class="">
                            <div class="ml-5 my-5 float-left" style="width:40%">
                                <div class="padd">
                                    <label class="text-primary inputtext w-100">Product</label>
                                    <input type="text" name="proname" class="form-control inputadjust textadjust" readonly>
                                    <label class="text-primary inputtext w-100 mt-4">Quantity</label>
                                    <input type="number" name="qty" class="form-control inputadjust textadjust" readonly>
                                </div>
                            </div>
                            <div class="mr-5 my-5  float-right" style="width:40%">
                                <div class="padd">
                                    <label class="text-primary inputtext w-100">Product</label>
                                    <input type="text" name="product_name" class="form-control inputadjust textadjust">
                                    <label class="text-primary inputtext w-100 mt-4">Quantity</label>
                                    <input type="number" name="quantity" class="form-control inputadjust textadjust">
                                </div>
                            </div>
                        </form>

                        <div class="modal-footer w-100">
                            <div class="justify-content-center w-100 d-flex flex-column">
                                <div class="py-3 align-self-center">

                                    <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                    <button type="button" class="btn btn-success btnmod" onclick="updateCustomerInventory('store');">
                                        UPDATE
                                    </button>
                                </div>
                                <p class = "outputmod align-self-center" style="width:50%; font-size:15px;  text-align:center;font-weight: 600; opacity:0;"></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 -->

        <div class="modal fade" id="addCustomerInventory" role="dialog">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ml-3">Add Product</h5>
                        <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">�</button>
                    </div>
                    <div class="modal-body nopadding">

                        <form role="form" method="get" id="addproduct_form" class="">
                            <div class="mx-5 px-4 my-2">
                                <div class="padd mb-2">
                                    <label class="text-primary inputtext w-100 mt-3">Product</label>
                                    <select  qty = "" onchange = "selproduct($(this));" class="productlist visible form-control" name="product_name"></select>
                                </div>
                                <div class="padd row">
                                    <span class = "col-4">
                                        <label class="text-primary inputtext w-100 mt-3">Available</label>
                                        <input type="number" name="stock" class="qtyavailable form-control inputadjust textadjust" readonly>
                                    </span>
                                    <span class = "col-4">
                                        <label class="text-primary inputtext w-100 mt-3">Retail Price</label>
                                        <input type="number" name="rprice" class="retailp form-control inputadjust textadjust" readonly>
                                    </span>
                                    <span class = "col-4">
                                        <label class="text-primary inputtext w-100 mt-3">WholeSale Price</label>
                                        <input type="number" name="wprice" class="wholesalep form-control inputadjust textadjust" readonly>
                                    </span>
                                </div>
                                <div class="padd mb-2">
                                    <label class="text-primary inputtext w-100 mt-3">Price System</label>
                                    <select  class="pricesystem visible form-control" name="pricesystem">
                                    <option value='' disabled selected hidden>select Price System</option>
                                    <option value = "retail">Retail</option>
                                    <option value = "wholesale">Wholesale</option>
                                    </select>
                                </div>
                                <div class="padd">
                                    <label class="text-primary inputtext w-100 mt-3">New Quantity</label>
                                    <input type="number" name="quantity" class="newqty form-control inputadjust textadjust">
                                </div>
                                <div class="padd">
                                    <label class="text-primary inputtext w-100 mt-3">Paid Amount</label>
                                    <input type="number" name="paidamt" class="paid form-control inputadjust textadjust">
                                </div>
                            </div>
                        </form>

                        <div class="modal-footer w-100">
                            <div class="justify-content-center w-100 d-flex flex-column">
                                <div class="py-3 align-self-center">

                                    <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                    <button type="button" class="btn btn-success btnmod" onclick="addProductToInvoice();">
                                        ADD
                                    </button>
                                </div>
                                <p class = "outputmod align-self-center" style="width:50%; font-size:15px;  text-align:center;font-weight: 600; opacity:0;"></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="print" role="dialog">
            <div class="modal-dialog modal-lg" style="background:#fff;">
                <div class="modal-header">
                    <h5 class="modal-title ml-3">Print Preview</h5>
                    <button type="button" class="close" id="closeInvoice" data-dismiss="modal" onclick="  ">�</button>
                </div>
                <div class="modal-body nopadding">
                    <div class="printinv mx-4 text-center" style="margin-top:10px;">
                        <div class="invheader">
                            <div class="float-left w-50 mb-2" style="text-align:left;">
                                <h3 style="color:#333;" class="my-2">SALES INVENTORY</h3>
                                <h5 class=" mt-4"><span class="fromdate">sddfdgd</span><span class="mx-4">-</span><span class="todate">sfsfssvs</span></h5>
                            </div>
                            <div class="float-right w-50 mb-2" style="text-align:right;font-size:12px">
                                <img  class = "mx-auto mb-3" width = 130px height = 70px src = "assets/img/logo.png"/>
                                <div style="font-family: 'verdana', sans-serif;">NAME : <h6 class="name my-3" style="display:inline;font-size:12px"></h6></div>
                                <div style="font-family: 'verdana', sans-serif;">PHONE : <p class="phonenum my-3" style="display:inline;font-size:12px"></p></div>
                                <div style="font-family: 'verdana', sans-serif;">ADDRESS : <p class="address my-3" style="display:inline;font-size:12px"></p></div>
                            </div>
                        </div>
                        <div class="inventorybody" class = "w-100" style="text-decoration: none; list-style-type: none !important;">

                        </div>
                        <style>
                            @media print{
                                .row {
                                    display: -webkit-box;
                                    display: -webkit-flex;
                                    display: -ms-flexbox;
                                    display: flex;
                                    -webkit-flex-wrap: wrap;
                                    -ms-flex-wrap: wrap;
                                    flex-wrap: wrap;
                                    /*margin-right: -15px;
                                    margin-left: -15px;*/
                                }
                                ul{
                                    /*border: 1px solid #333;*/
                                }
                                .pro-item{
                                    /*box-shadow: 0px 0px 0px 1px #333; 
                                    padding-top: 7px;*/
                                }
                                .w-100 {
                                    width: 100% !important;
                                }
                                .div-pill{
                                    color:black;
                                }
                                .opac{
                                    opacity: 0 !important;
                                }
                                .saleshd .div-pill:nth-child(1){
                                    width:  10% !important;
                                }
                                .saleshd .div-pill:nth-child(2){
                                    width:  15% !important;
                                }
                                .saleshd .div-pill:nth-child(3){
                                    width:  10% !important;
                                }
                                .saleshd .div-pill:nth-child(4){
                                    width:  9% !important;
                                }
                                .saleshd .div-pill:nth-child(5){
                                    width:  9% !important;
                                }
                                .saleshd .div-pill:nth-child(6){
                                    width:  15% !important;
                                }
                                .saleshd .div-pill:nth-child(7){
                                    width:  9% !important;
                                }
                                .saleshd .div-pill:nth-child(8){
                                    width:  10% !important;
                                }
                                .saleshd .div-pill:nth-child(9){
                                    width:  13% !important;
                                }
                                .justify-content-between {
                                    -webkit-box-pack: justify !important;
                                    -webkit-justify-content: space-between !important;
                                    -ms-flex-pack: justify !important;
                                    justify-content: space-between !important;
                                }

                                .mb-4 {
                                    margin-bottom: 1.5rem !important;
                                }
                                .my-4 {
                                    margin-top: 1.5rem !important;
                                    margin-bottom: 1.5rem !important;
                                }

                                .stockhd .div-pill:nth-child(1){
                                    width:  10% !important;
                                }
                                .stockhd .div-pill:nth-child(2){
                                    width:  30% !important;
                                }
                                .stockhd .div-pill:nth-child(3){
                                    width:  10% !important;
                                }
                                .stockhd .div-pill:nth-child(4){
                                    width:  10% !important;
                                }
                                .stockhd .div-pill:nth-child(5){
                                    width:  10% !important;
                                }
                                .stockhd .div-pill:nth-child(6){
                                    width:  10% !important;
                                }
                                .stockhd .div-pill:nth-child(7){
                                    width:  20% !important;
                                }
                                .chght{
                                    height: 10px;
                                }
                                .notvisible {
                                    opacity: 0;
                                    display:none;
                                }

                                .list li{
                                    text-decoration: none;
                                    list-style-type: none !important;
                                    cursor:pointer;
                                }
                                .listrow{
                                    font-size:13px; 
                                    display:inline-block; 
                                    text-align:center;
                                    vertical-align: middle;
                                }
                                .list{
                                    text-decoration: none;
                                    list-style-type: none !important;
                                    width:100%;
                                    font-family: 'Montserrat', sans-serif;
                                    position: static;
                                    z-index: -2;
                                    margin-left: -28px !important;
                                    border: 1px solid #999;
                                }
                                .saleshd{
                                    border-top: 1px solid #999;
                                }
                                .inventorybody .list .pro-item{
                                    margin: 14px auto !important;
                                    border-bottom: 1px solid #999;
                                }
                                .mx-auto {
                                    margin-right: auto !important;
                                    margin-left: auto !important;
                                }
                                .float-right {
                                    float: right !important;
                                }
                                .mx-4 {
                                    margin-right: 1.5rem !important;
                                    margin-left: 1.5rem !important;
                                }
                                .mt-4 {
                                    margin-top: 1.5rem !important;
                                }
                                .my-2 {
                                    margin-top: 0.5rem !important;
                                    margin-bottom: 0.5rem !important;
                                }
                                .py-2 {
                                    padding-top: 0.5rem !important;
                                    padding-bottom: 0.5rem !important;
                                }
                                .w-50 {
                                    width: 50% !important;
                                }
                                .mx-4 {
                                    margin-right: 1.5rem !important;
                                    margin-left: 1.5rem !important;
                                }
                                .text-center {
                                    text-align: center !important;
                                }
                                .float-left {
                                    float: left !important;
                                }
                            }
                        </style>
                    </div>
                    <div class="modal-footer w-100">
                        <div class="justify-content-center w-100 d-flex flex-column">
                            <div class="py-3 align-self-center">

                                <img class="createloadgif" src="./assets/img/loader.gif" width="90px" height="60px" class="" style="position:absolute !important; visibility:hidden; margin-bottom:20px;margin-left:5px;">
                                <button type="button" class="btn btn-success " onclick="printnow($(this));" id="btnprint">
                                    PRINT
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
