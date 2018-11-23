var tester;
var json;
var datalist;
var sales;
var stock;
var $cust_inv = [];
var sess;
var name;
var mylist;

var fns = {};
fns.activaterow = function activaterow(a, b, c) {
    $(a).animate({
        opacity: 1
    });
    $(b).each(function (index) {
        if ($(this).html() == c) {
            //$(this).css("display","none");
            $(this).closest("li").trigger("click");
        } else {
            console.log($(this).html());
        }

    });
}


$(window).resize(organiseSidebar);

$(document).ready(function () {

    $("#dataToggler").click(function (e) {
        $(".tab .mang").toggleClass("chgwt");
        var windowWidth = $(window).width();
        if (windowWidth > 579) {
            console.log('collap');
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
            $(".menunames").toggleClass("collapsein");
        } else {
            var collap = $('#sidebar').css('height');
            (parseInt(collap) > 70) ? collapseSidebar() : openSidebar();
        }

        $('#dataToggler').toggleClass("is-active");

    });
    sess = $(".adminref").text();
    $('.modal').on('hidden.bs.modal', function () {
        $(".textadjust").val("");
        $("[type=radio]").prop("checked", false);
        console.log("emptymodal");
    });

    $(".textadjust").on("click", function (e) {
        $(this).select();
    });


    $(document).ready(function () {
        $('.sdate').datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        });
    });
    $(document).ready(function () {
        $('.exp').datepicker({
            dateFormat: "yy-mm-dd",
            minDate: +1,
            changeMonth: true,
            changeYear: true
        });
    });

    $('.sdate').keyup(function (evt) {
        $(this).val('');
    });
    $('.exp').keyup(function () {
        $(this).val('');
    });


    //used switch the sidebarlinks active and inactive
    $("#navmenu a").click(function (e) {
        thisa = $(this);
        if ($(".active")[0]) {
            $(".active").attr("disabled", "");;
            $(".active").toggleClass("active");
            $("#tabs .visible").fadeOut(300, function () {
                $(this).toggleClass("visible notvisible");
                $(thisa).addClass("active");
                $(thisa).attr("disabled", "disabled");
                tabid = $(thisa).attr("href");
                $(tabid).toggleClass("notvisible visible");
                $(tabid).fadeIn(300);
                $(thisa).attr("data-str") && $(thisa).attr("data-act") ? dbOperations($(thisa).attr("data-str"), $(thisa).attr("data-act"), $(thisa).attr("data-str")) : null;
            });
        }
    });

});

function togglehisttab(a) {
    $("." + a + " .tab1").css("display", "block");
    $("." + a + " .tab2").css("display", "none");
}

function printnow() {
    $('#print').modal('hide');
    w = window.open();
    w.document.write($(".printinv").html());
    w.print();
    w.close();
}

function tablefilter(a, b) {
    var value = $(a).val().toLowerCase();
    $("#" + b + " tbody tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        console.log($(this).text());
    });
}

//used to organise the sidebar responsiveness
function collapseSidebar() {
    console.log('igothere');
    $('#sidebar').animate({
        height: 65
    }, 300);
}

function openSidebar() {
    var ht = $('#sidebar').get(0).scrollHeight;
    $('#sidebar').animate({
        height: ht
    }, 200);
}

function organiseSidebar() {
    var windowWidth = $(window).width();
    (windowWidth > 578) ? resizesideleft() : resizesidetop();
    console.log(windowWidth);
}

function resizesidetop() {
    $('#sidebar').css('height', '65px');
}

function resizesideleft() {
    $('#sidebar').css('height', '100%');

}

function getdata(a) {

    var startdate = $("#startdate").val();
    var enddate = $("#enddate").val();
    var datainfo = $("#sales-stock").text();

    console.log(startdate);
    console.log(enddate);
    console.log(datainfo);
    console.log($(a).text());

    if (startdate != "" && enddate != "") {
        if ($(a).text() != "GET") {
            switch (datainfo) {
                case "Sales":
                    $(".rechd.onact").toggleClass("notvisible onact");
                    $(".saleshd").toggleClass("notvisible onact");
                    break;
                case "Stock":
                    $(".rechd.onact").toggleClass("notvisible onact");
                    $(".stockhd").toggleClass("notvisible onact");
                    break;
                case "Invoice Updates":
                    $(".rechd.onact").toggleClass("notvisible onact");
                    $(".invupdatehd").toggleClass("notvisible onact");
                    break;
            }
        }
        if (datainfo == "Sales") {
            $("#salessearch").val() == "" || $("#salessearch").val() == " " ? dbOperations("customerinvoice", "select_operation", ["customerinvoice", ["date", "date"], [startdate, enddate], [">=^<="]]) : dbOperations("customerinvoice", "select_operation", ["customerinvoice", ["customer", "date", "date"], [$("#salessearch").val(), startdate, enddate], ["=^>=^<="]]);

            $(a).text() != "GET" ? $(".moneyinfo.opac").toggleClass("opac") : null;
            /* $(".moneyrep.chght").toggleClass("chght");
            $("#sale .list.chgpadd").toggleClass("chgpadd");*/
        } else if (datainfo == "Stock") {
            $("#salessearch").val() == "" || $("#salessearch").val() == " " ? dbOperations("stock", "select_operation", ["stock", ["entry_date", "entry_date"], [startdate, enddate], [">=^<="]]) : dbOperations("stock", "select_operation", ["stock", ["productname", "entry_date", "entry_date"], [$("#salessearch").val(), startdate, enddate], ["=^>=^<="]]);
            $(a).text() != "GET" ? $(".moneyinfo").toggleClass("opac") : null;
            /*$(".moneyrep").toggleClass("chght");
            $("#sale .list").toggleClass("chgpadd");*/
        } else if (datainfo == "Invoice Updates") {
            dbOperations("customerupdate", "select_operation", ["customerupdate", ["update_date", "update_date"], [startdate, enddate], [">=^<="]]);
            /*$(".moneyinfo").toggleClass("opac");*/
            /*$(".moneyrep").toggleClass("chght");
            $("#sale .list").toggleClass("chgpadd");*/
        }
    } else {
        if ($(a).text() != "GET") {
            switch (datainfo) {
                case "Sales":
                    $(".rechd.onact").toggleClass("notvisible onact");
                    $(".saleshd").toggleClass("notvisible onact");
                    break;
                case "Stock":
                    $(".rechd.onact").toggleClass("notvisible onact");
                    $(".stockhd").toggleClass("notvisible onact");
                    break;
                case "Invoice Updates":
                    $(".rechd.onact").toggleClass("notvisible onact");
                    $(".invupdatehd").toggleClass("notvisible onact");
                    break;
            }
        }
        if (datainfo == "Sales") {
            $("#salessearch").val() == "" || $("#salessearch").val() == " " ? dbOperations("customerinvoice", "select_operation", ["customerinvoice"]) : dbOperations("customerinvoice", "select_operation", ["customerinvoice", ["customer"], [$("#salessearch").val()], ["="]]);
            $(a).text() != "GET" ? $(".moneyinfo.opac").toggleClass("opac") : null;
            /*$("#sale .list.chgpadd").toggleClass("chgpadd");
            $(".moneyrep.chght").toggleClass("chght");*/
        } else if (datainfo == "Stock") {
            $("#salessearch").val() == "" || $("#salessearch").val() == " " ? dbOperations("stock", "select_operation", ["stock"]) : dbOperations("stock", "select_operation", ["stock", ["productname"], [$("#salessearch").val()], ["="]]);
            $(a).text() != "GET" ? $(".moneyinfo").toggleClass("opac") : null;
            /*$("#sale .list").toggleClass("chgpadd");
            $(".moneyrep").toggleClass("chght");*/
        } else if (datainfo == "Invoice Updates") {
            dbOperations("customerupdate", "select_operation", ["customerupdate"]);
            /* $(".moneyinfo").toggleClass("opac");*/
            /*$(".moneyrep").toggleClass("chght");
            $("#sale .list").toggleClass("chgpadd");*/
        }
    }
}

function printtab() {
    $(".inventorybody").empty();
    $(".address").text("");
    $(".phonenum").text("");
    $(".name").text("");
    $(".invheader .fromdate").text("startdate");
    $(".invheader .todate").text("enddate");
    apar = $(".address").parent();
    ppar = $(".phonenum").parent();
    if ($("#sales-stock").text() == "Stock") {
        $(".invheader h3").text("STOCK INVENTORY");
        $(apar).css("opacity", "0");
        $(ppar).css("opacity", "0");
    } else {
        $(".invheader h3").text("SALES INVENTORY");
        if ($("#salessearch").val() != "") {
            $(apar).css("opacity", "1");
            $(ppar).css("opacity", "1");
        } else {
            $(apar).css("opacity", "0");
            $(ppar).css("opacity", "0");
        }

    }
    var startdate = $("#startdate").val();
    var enddate = $("#enddate").val();
    if (startdate != "" && enddate != "") {
        $(".invheader .fromdate").text(startdate);
        $(".invheader .todate").text(enddate);
    }
    $("#salessearch").val() == "" ? $(".name").text("ALL BUYERS") : $(".name").text($("#salessearch").val());

    var printArea = $(".invtable").html();
    $(".inventorybody").append($(".moneyrep").clone());
    $(".inventorybody").append(printArea);
    $(".inventorybody").append($("#rec .list").clone());
    /*$.get("")*/
    console.log(json);
    for (var f = 0; f < json.length; f++) {
        if (json[f].customer_name == $(".name").text()) {
            $(".address").html(json[f].address);
            $(".phonenum").html(json[f].customer_phone);
            console.log(json[f].address);
        }
    }

}

function dbOperations(str, act, arg, args, extargs) {
    if (act) {

    } else {
        act = ""
    }
    if (arg) {

    } else {
        arg = ""
    }
    if (args) {

    } else {
        args = []
    }
    if (extargs) {

    } else {
        extargs = []
    }
    url = "./assets/php/getlist.php?type=" + String(str) + "&act=" + String(act) + "&arg=" + String(arg) + "&sess=" + sess;
    $.get(url, function (data, status) {
        var options;
        mylist = null;
        console.log(data);
        datalist = data;
        switch (str) {
            case "users":
                $("#account-list .list").empty();
                options = {
                    valueNames: ['username', 'category'],
                    // Since there are no elements in the list, this will be used as template.
                    item: '<li class = "pro-item" onclick = "viewUsersession($(this))"><div><div style = "font-size:17px; float:left; width:50%; text-align:left" class="username"></div><div style = "font-size:17px; float:right; width:50%; text-align:center" class="category"></div></div><div style = "clear:both"></div></li>'
                };
                values = JSON.parse(data);

                console.log(options);

                mylist = new List('account-list', options, values);

                check_for_active_row("username", "acc");

                break;

            case "products":
                console.log("data");
                $("#product-list .list").empty();
                options = {
                    valueNames: ['product_name', 'product_description', 'stock', 'product_retailprice', 'product_wholesaleprice', 'expiry_date'],
                    // Since there are no elements in the list, this will be used as template.
                    item: '<li class = "pro-item" onclick = "viewProductStock($(this));"><div><div style = "width:20%; text-align:left !important;" class="listrow product_name"></div><div style = "width:35%;" class="listrow product_description"></div><div style = "width:10%;" class="listrow stock"></div><div style =  width:10%;" class="listrow product_retailprice"></div><div style = "width:10%;" class="listrow product_wholesaleprice"></div><div style = "width:15%;" class="listrow expiry_date"></div></div><div style = "clear:both"></div></li>'
                };
                values = JSON.parse(data);

                console.log(options);

                mylist = new List('product-list', options, values);

                $(".updateprodbtn").hasClass("deactivate") ? null : $(".updateprodbtn").addClass("deactivate");
                if (extargs.length <= 0) {
                    check_for_active_row("product_name", "stock");
                }
                if (extargs.length > 0) {
                    fns["activaterow"](extargs[0], extargs[1], extargs[2]);
                }
                console.log(extargs);
                break;

            case "customerinvoice":
                console.log(data);
                $("#sales-list .list").empty();
                options = {
                    valueNames: ['date', 'customer', 'invno', 'totalamt', 'totalpaid', 'outbalance', 'category', 'salesref', 'paymeth'],
                    // Since there are no elements in the list, this will be used as template.
                    item: '<li class = "pro-item" onclick = "viewSales($(this));"><div><div style = "width:10%; text-align:left !important;" class="listrow date"></div><div style = "width:15%;" class="listrow customer"></div><div style = "width:10%;" class="listrow invno"></div><div style =  "width:9%;" class="listrow totalamt"></div><div style = "width:9%;" class="listrow totalpaid"></div><div style = "width:15%;" class="listrow outbalance"></div><div style = "width:9%;" class="listrow category"></div><div style = "width:10%;" class="listrow salesref"></div><div style = "width:13%;" class="listrow paymeth"></div></div><div style = "clear:both"></div></li>'
                };
                values = JSON.parse(data);

                console.log(options);

                mylist = new List('sales-list', options, values);


                //mylist.search(); 

                var lent = $("#sales-list .list li").length;

                $("#entryno").text(lent);

                var cas = 0;
                var pos = 0;
                var che = 0;
                var cre = 0;
                $("#sales-list .list .paymeth").each(function (index, element) {
                    switch ($(element).html().toLowerCase()) {
                        case "cash":
                            elm = $("#sales-list .list .totalpaid")[index];
                            cas += parseInt($(elm).html());
                            break;
                        case "credit":
                            elm = $("#sales-list .list .totalpaid")[index];
                            cre += parseInt($(elm).html());
                            break;
                        case "cheque":
                            elm = $("#sales-list .list .totalpaid")[index];
                            che += parseInt($(elm).html());
                            break;
                        case "pos":
                            elm = $("#sales-list .list .totalpaid")[index];
                            pos += parseInt($(elm).html());
                            break;
                    }
                });

                var tot = 0;
                lastoutbal = $(".outbalance")[parseInt(lent) - 1];
                $("#sales-list .list li .totalamt").each(function (index, element) {
                    tot += parseInt($(element).html());
                });

                totmoney = cre + cas + pos + che;
                console.log(cas);
                $("#cash").text(cas);
                $("#pos").text(pos);
                $("#cheque").text(che);
                $("#credit").text(cre);
                $("#totpaid").text(totmoney);
                $("#totcost").text(tot);
                $("#totoutbal").text($(lastoutbal).html());
                $("#salessearch").val() != "" && data ? $(".moneyinfo.outbal").css("opacity", "1") : $(".moneyinfo.outbal").css("opacity", "0");
                /*dbOperations("cust", "select_customers", []);*/
                break;

            case "stock":
                console.log(data);
                $("#sales-list .list").empty();
                options = {
                    valueNames: ['entry_date', 'productname', 'stockbought', 'stocksold', 'stockremain', 'entries', 'expirydate'],
                    // Since there are no elements in the list, this will be used as template.
                    item: '<li class = "pro-item" onclick = "viewStock($(this));"><div><div style = "width:10%; text-align:left !important;" class="listrow entry_date"></div><div style =  "width:20%;" class="listrow productname"></div><div style = "width:15%;" class="listrow stockbought"></div><div style = "width:10%;" class="listrow stocksold"></div><div style = "width:15%;" class="listrow stockremain"></div><div style = "width:10%;" class="listrow entries"></div><div style = "width:20%;" class="listrow expirydate"></div></div><div style = "clear:both"></div></li>'
                };
                values = JSON.parse(data);

                console.log(options);

                mylist = new List('sales-list', options, values);

                $("#entryno").text($("#sales-list .list li").length);

                break;

            case "customerupdate":
                console.log(data);
                $("#sales-list .list").empty();
                options = {
                    valueNames: ["customer_name", "invoice", "update_date", "totalamt", "added_amt", "oldpaid", "newpaid", "old_outbal", "new_outbal", "user_update"],
                    // Since there are no elements in the list, this will be used as template.
                    item: '<li class = "pro-item" onclick = "viewStock($(this));"><div><div style = "width:10%; text-align:left !important;" class="listrow customer_name"></div><div style =  "width:10%;" class="listrow invoice"></div><div style = "width:10%;" class="listrow update_date"></div><div style = "width:10%;" class="listrow totalamt"></div><div style = "width:10%;" class="listrow added_amt"></div><div style = "width:10%;" class="listrow oldpaid"></div><div style = "width:10%;" class="listrow newpaid"></div><div style = "width:10%;" class="listrow old_outbal"></div><div style = "width:10%;" class="listrow new_outbal"></div><div style = "width:10%;" class="listrow user_update"></div></div><div style = "clear:both"></div></li>'
                };
                values = JSON.parse(data);

                console.log(options);

                mylist = new List('sales-list', options, values);

                $("#entryno").text($("#sales-list .list li").length);

                break;

            case "customers":
                $("#customer-list .list").empty();
                options = {
                    valueNames: ['customer_name', 'last_visit', 'visit_count', 'outstanding_balance', 'customer_phone', 'customer_email', 'address'],
                    // Since there are no elements in the list, this will be used as template.
                    item: '<li class = "pro-item" onclick = "viewcustomer($(this))"><div><div style = "width:15%; text-align:left !important;" class="listrow customer_name"></div><div style = "width:10%;" class="listrow last_visit"></div><div style = "width:5%;" class="listrow visit_count"></div><div style =  width:15%;" class="listrow outstanding_balance"></div><div style = "width:15%;" class="listrow customer_phone"></div><div style = "width:20%;" class="listrow customer_email"></div><div style = "width:20%;" class="listrow address"></div></div><div style = "clear:both"></div></li>'
                };
                values = JSON.parse(data);
                json = values;
                console.log(options);
                $(".updatecustbtn").hasClass("deactivate") ? null : $(".updatecustbtn").addClass("deactivate");
                mylist = new List('customer-list', options, values);
                if (extargs.length <= 0) {
                    check_for_active_row("customer_name", "inventory");
                }
                if (extargs.length > 0) {
                    fns["activaterow"](extargs[0], extargs[1], extargs[2]);
                }
                /*check_for_active_row("customer_name", "inventory");*/


                break;

            case "stocks":
                $('#prodlist').empty();
                //console.log(data);
                if (data != "") {
                    json = JSON.parse(data);
                    var stri = "";
                    stockdisp = "stockdisp";
                    for (var a = 0; a < json.length; a++) {
                        stri += '<tr id="tablerow' + a + '" class = "trow" onclick = "togglerow($(this),' + stockdisp + ');"><td style="text-align: center; display:none;" class="tdel id">' + json[a].id + '</td><td style="text-align: center;" class="tdel expydate">' + json[a].expirydate + '</td><td style="text-align: center;" class="tdel stockbought">' + json[a].stockbought + '</td><td style="text-align: center;" class="tdel stocksold">' + json[a].stocksold + '</td><td style="text-align: center;" class="tdel stockremain">' + json[a].stockremain + '</td><td style="text-align: center;" class="tdel stockentrydate">' + json[a].entry_date + '</td></tr>'
                    }
                    $('#prodlist').append(stri);
                }
                break;

            case "inventory":
                $('#inventorylist').empty();
                //console.log(data);
                $inv = [];
                if (data != "") {
                    json = JSON.parse(data);
                    inventorydisp = "inventorydisp";
                    var stri = "";
                    for (var a = 0; a < json.length; a++) {
                        stri += '<tr id="tablerow' + a + '" class = "trow" onclick = "togglerow($(this),' + inventorydisp + ');"><td style="text-align: center;display:none;" pos = ' + a + ' class="tdel sales_invid">' + json[a].id + '</td><td style="text-align: center;" pos = ' + a + ' class="tdel salesdate">' + json[a].date + '</td><td pos = ' + a + ' style="text-align: center;" class="tdel invoiceno">' + json[a].invno + '</td><td pos = ' + a + ' style="text-align: center;" class="tdel invoicetotal">' + json[a].totalamt + '</td><td pos = ' + a + ' style="text-align: center;" class="tdel invoicepaid">' + json[a].totalpaid + '</td><td pos = ' + a + ' style="text-align: center;" class="tdel invoiceoutbal">' + json[a].outbalance + '</td></tr>';

                        $inv = [json[a].totalamt, json[a].totalpaid, json[a].outbalance];
                    }
                    $('#inventorylist').append(stri);
                }
                $cust_inv.push($inv);
                break;

            case "stockentries":
                //console.log(data);
                $('#prodlistdetails').empty();
                //
                if (data != "") {
                    json = JSON.parse(data);
                    var stri = "";
                    stockdisp = "stockdisp";
                    for (var a = 0; a < json.length; a++) {
                        if (json[a].stocktype == "new") {
                            stri += '<tr id="tablerow' + a + '" class = "trow" onclick = "togstockentryrow($(this),' + stockdisp + ');"><td style="text-align: center;display:none;" class="tdel myid">' + json[a].id + '</td><td style="text-align: center;" class="tdel edate">' + json[a].entry_date + '</td><td style="text-align: center;" class="tdel stkq">' + json[a].stockno + '</td><td style="text-align: center;" class="tdel byadmin">' + json[a].byadmin + '</td>';
                        }
                    }
                    console.log(String($(".stockdisp .stockbought").html()));
                    $('#prodlistdetails').append(stri);
                    $(".expdt").html(json[0].stockexpiry_date);
                    $(".totstk").html(String($("tr.actparent .stockbought").html()));
                    $(".sldstk").html(String($("tr.actparent .stocksold").html()));
                    $(".lftstk").html(String($("tr.actparent .stockremain").html()));
                }
                break;

            case "inventorydetails":
                //console.log(data);
                $('#inventorylistdetails').empty();
                //
                inventorydisp = 'inventorydisp';
                if (data != "") {
                    json = JSON.parse(data);
                    var stri = "";
                    for (var a = 0; a < json.length; a++) {
                        stri += '<tr id="tablerow' + a + '" class = "trow" onclick = "togglerow($(this),' + inventorydisp + ');"><td style="text-align: center; display:none;" class="tdel id">' + json[a].id + '</td><td style="text-align: center;" class="tdel salesproduct">' + json[a].product + '</td><td style="text-align: center;" class="tdel salesqty">' + json[a].quantity + '</td><td style="text-align: center;" class="tdel salestotamt">' + json[a].totalprice + '</td>' + '</td><td style="text-align: center;" class="tdel pricetype">' + json[a].pricetype + '</td>';
                    }

                    $('#inventorylistdetails').append(stri);
                    $(".Totalamtbt").html(json[0].totalamt);
                    $(".Totalspent").html(json[0].paidamt);
                    $(".salesreff").html(json[0].saleref);
                    $(".invnum").html(json[0].invoiceno);
                    $(".datesale").html(json[0].salesdate);
                }
                break;

            case "sessions":
                //console.log(data);
                $('#userlist').empty();
                json = JSON.parse(data);
                var stri = "";
                for (var a = 0; a < json.length; a++) {
                    stri += '<tr id="tablerow' + a + '" class = "trow"><td style="text-align: center;" class="tdel">' + json[a].username + '</td><td style="text-align: center;" class="tdel">' + json[a].log_on + '</td><td style="text-align: center;" class="tdel">' + json[a].log_off + '</td><td style="text-align: center;" class="tdel">' + json[a].duration + '</td></tr>'
                }
                $('#userlist').append(stri);
                break;

            case "del":
                //console.log(data);
                dbOperations("products", "select_operation", "products", args, extargs);
                dbOperations("customers", "select_operation", "customers", args, extargs);
                //fns["activaterow"](extargs[0],extargs[1],extargs[2]);

                if (extargs[0] == "#product-list") {
                    dbOperations("stocks", "select_operation", ["stock", "productname", String($(".prodname").html())]);
                    console.log(String($(".stockdisp .expdt").html()));
                    dbOperations("stockentries", "select_operation", ["stockentry", ["stockexpiry_date", "product"], [String($(".stockdisp .expdt").html()), $(".product_name.act").html()]]);
                }
                if (extargs[0] == "#customer-list") {
                    dbOperations("inventory", "select_operation", ["customerinvoice", "customer", String($(".custname").html())]);
                }

                check_for_active_row(args[0], args[1]);
                break;

            case "":
                /*console.log(data);*/
                $(".unactivate").toggleClass("deactivate unactivate");
                $(".createloadgif").css("visibility", "hidden");
                //console.log(data);
                if (data.substring(0, 6) == "values") {
                    data.substring(7, 11) == "will" ? $('.outputmod').css("color", "#DD2A2A") : $('.outputmod').css("color", "#25a249");
                    $('.outputmod').text('values have been inserted').fadeTo('slow', 1).delay(2000)
                        .fadeTo('slow', 0, function () {
                            $(".btnmod").css("visibility", "visible");
                            $('.outputmod').css("display", "none");
                            act == "update_operation" ? $(".modal .close").trigger("click") : null;
                        });
                    if (extargs.length > 0) {
                        dbOperations("products", "select_operation", "products", args, extargs);
                        dbOperations("customers", "select_operation", "customers", args, extargs);
                        //fns["activaterow"](extargs[0],extargs[1],extargs[2]);

                        if (extargs[0] == "#product-list") {
                            dbOperations("stocks", "select_operation", ["stock", "productname", String($(".prodname").html())]);
                            console.log(String($(".stockdisp .expdt").html()));
                            dbOperations("stockentries", "select_operation", ["stockentry", ["stockexpiry_date", "product"], [String($(".stockdisp .expdt").html()), $(".product_name.act").html()]]);
                        } else if (extargs[0] == "#inventorylist") {
                            dbOperations("inventory", "select_operation", ["customerinvoice", "customer", String($(".customername").html())]);
                        }
                    } else {
                        $('#navmenu .active').trigger("click");
                    }

                    check_for_active_row(args[0], args[1]);
                } else {
                    $('.outputmod').css("color", "#DD2A2A");
                    $('.outputmod').text(data).fadeTo('slow', 1).delay(2000)
                        .fadeTo('slow', 0, function () {
                            $(".btnmod").css("visibility", "visible");
                            $('.outputmod').css("display", "none");
                            act == "update_operation" ? $(".modal .close").trigger("click") : null;
                        });
                }
                break;

        }
    });
}

function refreshpage() {
    $('#navmenu .active').trigger("click");
}

function viewSales(obj) {
    str = obj.find(".customer").html();
    $("#salessearch").val(str);
    mylist.search(str);
}
function viewStock(obj) {
    str = obj.find(".productname").html();
    $("#salessearch").val(str);
    mylist.search(str);
}

//used to check for selected rows on a list
function check_for_active_row(activelink, panedisp) {
    if ($("." + String(activelink) + ".act")[0]) {
        $("." + String(panedisp) + "nodisp").css("display", "none");
        $("." + String(panedisp) + "disp").css("display", "block");
    } else {
        $("." + String(panedisp) + "nodisp").css("display", "block");
        $("." + String(panedisp) + "disp").css("display", "none");
    }
}


function togstockentryrow(a, b) {
    $("." + b + " .deactivate").toggleClass("deactivate unactivate");
    $("tr.actparent").css("background-color", "#1C6A82");
    $("tr.actparent").toggleClass("actparent");
    $(a).css("background-color", "rgba(0,0,0, .5)");
    $(a).toggleClass("actparent");
}
/*

function toggleinventoryrow(a, b) {
    $("." + b + " .deactivate").toggleClass("deactivate unactivate");
    $("tr.actparent").css("background-color", "#25A54C");
    $("tr.actparent").toggleClass("actparent");
    $(a).css("background-color", "rgba(0,0,0, .5)");
    $(a).toggleClass("actparent");
}
*/

function togglerow(a, b) {
    $("." + b + " .unactivate").toggleClass("deactivate unactivate");
    if ($(a).hasClass("actparent")) {
        if (b == "stockdisp") {
            $("." + b + " .tab1").toggle();
            $("." + b + " .tab2").toggle();
            getstockentries($(a).find(".expydate"));
        } else if ($(".actparent .invoiceno").html() != "debtpay") {
            $("." + b + " .tab1").toggle();
            $("." + b + " .tab2").toggle();
            getcustomerinventorydetails($(a).find(".invoiceno"));
        }

    } else {
        b == "inventorydisp" ? $("." + b + " .deactivate").toggleClass("deactivate unactivate") : null;
        $("#prod tr.actparent").css("background-color", "#1C6A82");
        $("#cust tr.actparent").css("background-color", "#25A54C");
        $("tr.actparent").toggleClass("actparent");
        $(a).toggleClass("actparent");
        $(a).css("background-color", "rgba(0,0,0, .5)");
    }
}

function getstockentries(a) {
    console.log($(a).html());
    $("#producthistorypane").css("opacity", "0");
    dbOperations("stockentries", "select_operation", ["stockentry", ["stockexpiry_date", "product"], [String($(a).html()), $(".product_name.act").html()]]);
    check_for_active_row("product_name", "stock");
    $("#producthistorypane").animate({
        opacity: 1
    });
}

function getcustomerinventorydetails(a) {
    console.log($(a).html());
    $("#customerhistorypane").css("opacity", "0");
    dbOperations("inventorydetails", "select_operation", ["sales", "invoiceno", String($(a).html())]);
    check_for_active_row("customer_name", "inventory");
    $("#customerhistorypane").animate({
        opacity: 1
    });
}


//used to delete user accounts from the database
function deleteUseraccount() {
    data = "name=" + String($(".username.act").html()) + "^class=User";
    dbOperations("user", "delete_operation", data);
    $("li.actparent").remove();
    $("#userhistorypane").css("opacity", "0");
    check_for_active_row("username", "acc");
    $("#userhistorypane").animate({
        opacity: 1
    });

}
//used to delete user accounts from the database
function deletecustomer() {
    data = "name=" + String($(".customer_name.act").html()) + "^class=Customer";
    dbOperations("cus", "delete_operation", data);
    $("li.actparent").remove();
    $("#customerhistorypane").css("opacity", "0");
    check_for_active_row("customer_name", "inventory");
    $("#customerhistorypane").animate({
        opacity: 1
    });
}
//used to delete user accounts from the database
function deleteProduct() {
    data = "name=" + String($(".product_name.act").html()) + "^class=Product";
    dbOperations("pro", "delete_operation", data);
    $("li.actparent").remove();
    $("#producthistorypane").css("opacity", "0");
    check_for_active_row("product_name", "stock");
    $("#producthistorypane").animate({
        opacity: 1
    });

}

//used to delete user accounts from the database
function deleteStock() {

    console.log($(".actparent .id").html());
    prodnam = $(".product_name.act").html();
    $("#product-list").css("opacity", "0");
    data = "id=" + String($(".actparent .id").html()) + "^del=Stock^class=Stock";
    dbOperations("del", "delete_operation", data, ["product_name", "stock"], ["#product-list", ".pro-item .product_name", prodnam]);
    //$("tr.actparent").remove();    
}

function deletedebtpayment() {
    if ($(".actparent .invoiceno").html() == "debtpay") {
        custnam = $(".customer_name.act").html();
        /*$("#product-list").css("opacity", "0");*/
        data = "id=" + String($(".actparent .sales_invid").html()) + "^class=Inventory";
        dbOperations("del", "delete_operation", data, ["customer_name", "inventory"], ["#customer-list", ".pro-item .customer_name", custnam]);
    }
    //$("tr.actparent").remove();    
}
//used to delete user accounts from the database
function deleteStockentry() {
    if ($("#stockentrytable tr").length > 2) {
        console.log($("tr.actparent .myid").html());
        prodnam = $(".product_name.act").html();
        data = "id=" + String($(".actparent .myid").html()) + "^del=Stockentry^class=Stock";
        dbOperations("del", "delete_operation", data, ["product_name", "stock"], ["#product-list", ".pro-item .product_name", prodnam]);
        //$("tr.actparent").remove();
    }
}

function deleteInventoryentry() {
    console.log($("tr.actparent .id").html());
    custnam = $(".customer_name.act").html();
    data = "id=" + String($("tr.actparent .id").html()) + "^class=Sales";
    dbOperations("del", "delete_operation", data, ["customer_name", "inventory"], ["#inventorylist", ".pro-item .customer_name", custnam]);
}

//used to view use sessions
function viewcustomer(a) {
    $(".inventorydisp .unactivate").toggleClass("deactivate unactivate");
    $("#customer-list .deactivate").toggleClass("deactivate");
    /*$(".customerdisp .unactivate").toggleClass("deactivate")*/
    $("li.actparent").toggleClass("actparent");
    if ($(".inventorydisp .tab1").css("display") == "none") {
        $(".inventorydisp .tab1").toggle();
        $(".inventorydisp .tab2").toggle();
    }
    $(".customer_name.act").toggleClass("act");
    //name = $(".username.act").html()
    $(a).find(".customer_name").toggleClass("act");
    $(a).toggleClass("actparent");
    name = $(".customer_name.act").html();
    console.log(name);
    $(".customername").text(name);
    $("#customerhistorypane").css("opacity", "0");
    dbOperations("inventory", "select_operation", ["customerinvoice", "customer", String($(".customername").html())]);
    check_for_active_row("customer_name", "inventory");
    $("#customerhistorypane").animate({
        opacity: 1
    });
}

//used to view use sessions
function viewProductStock(a) {
    $("#product-list .deactivate").toggleClass("deactivate");
    $(".stockdisp .unactivate").toggleClass("deactivate")
    $("li.actparent").toggleClass("actparent");
    if ($(".stockdisp .tab1").css("display") == "none") {
        $(".stockdisp .tab1").toggle();
        $(".stockdisp .tab2").toggle();
    }
    $(".product_name.act").toggleClass("act");
    //name = $(".username.act").html()
    $(a).find(".product_name").toggleClass("act");
    $(a).toggleClass("actparent");
    name = $(".product_name.act").html();
    console.log(name);
    $(".prodname").text(name);
    $("#producthistorypane").css("opacity", "0");
    dbOperations("stocks", "select_operation", ["stock", "productname", String($(".prodname").html())]);
    check_for_active_row("product_name", "stock");
    $("#producthistorypane").animate({
        opacity: 1
    });
}

//used to view use sessions
function viewUsersession(a) {
    $("li.actparent").toggleClass("actparent");
    $(".username.act").toggleClass("act");
    //name = $(".username.act").html()
    $(a).find(".username").toggleClass("act");
    $(a).toggleClass("actparent");
    name = $(".username.act").html();
    console.log(name);
    $(".usrnam").text(name);
    $("#userhistorypane").css("opacity", "0");
    dbOperations("sessions", "select_operation", ["users_session", "username", String($(".username.act").html())]);
    check_for_active_row("username", "acc");
    $("#userhistorypane").animate({
        opacity: 1
    })
}


//used to add user accounts to the db
function addUseraccount(a) {
    url = "./assets/php/create_admin.php";
    data = $("#user_form").serialize();
    data += "&echo=true";
    $("#btnadduser").css("visibility", "hidden");
    $(".createloadgif").css("visibility", "visible");
    $('#adduseroutput').css("display", "inline");
    $("#user_form .textadjust").val("");
    $.post(url, data, function (response) {
        $(".createloadgif").css("visibility", "hidden");
        console.log(response);
        if (response.substring(0, 6) == "values") {
            $('#adduseroutput').css("color", "#25a249");
            $('#adduseroutput').text(response).fadeTo('slow', 1).delay(2000)
                .fadeTo('slow', 0, function () {
                    $("#btnadduser").css("visibility", "visible");
                    $('#adduseroutput').css("display", "none");
                });
            $('#navmenu .active').trigger("click");
            check_for_active_row("username", "acc");
        } else {
            $('#adduseroutput').css("color", "#DD2A2A");
            $('#adduseroutput').text(response).fadeTo('slow', 1).delay(2000)
                .fadeTo('slow', 0, function () {
                    $("#btnadduser").css("visibility", "visible");
                    $('#adduseroutput').css("display", "none");
                });
        }

    });

}

//used to add user accounts to the db
function addProduct(a) {
    data = $("#product_form").serialize();
    data += "&class=Product";
    data = data.replace(/[&]/g, "^");
    $(".btnmod").css("visibility", "hidden"); dbOperations("", "add_operation", data, ["product_name", "stock"]);
    $("#product_form .textadjust").val("");

    $(".createloadgif").css("visibility", "visible");
    $('.outputmod').css("display", "inline");
}

function addcustomer(a) {
    data = $("#customer_form").serialize();
    data += "&class=Customer";
    data = data.replace(/[&]/g, "^");
    console.log(data);
    if ($("#customer_form [name=customer_name]").val() == "" || $("#customer_form [name=customer_email]").val() == "" ||
        $("#customer_form [name=customer_phone]").val() == "" || $("#customer_form [name=address]").val() == "") {
        /*$("#customer_form [name=customer_name]").val("nil");
        $("#customer_form [name=customer_email]").val("nil");
        $("#customer_form [name=customer_phone]").val("0");
        $("#customer_form [name=address]").val("nil"); */
        $(".btnmod").css("visibility", "hidden");
        dbOperations("", "add_operation", data, ["customer_name", "customer"]);
        $(".createloadgif").css("visibility", "visible");
        $('.outputmod').css("display", "inline");
    } else {
        $(".btnmod").css("visibility", "hidden");
        dbOperations("", "add_operation", data, ["customer_name", "customer"]);
        $(".createloadgif").css("visibility", "visible");
        $('.outputmod').css("display", "inline");
    }

    $("#customer_form .textadjust").val("");
}

//used to add user accounts to the db
function addStock(a, b) {
    if ($('.expstkdate').val() == '') {
        alert('fill expiry date');
        return;
    }
    data = $("#addStock_form").serialize();
    data += "&product=" + String(a) + "&byadmin=" + String(b) + "&class=Stock";
    data = data.replace(/[&]/g, "^");
    prodnam = $(".product_name.act").html();
    $("#product-list").css("opacity", "0");
    console.log(prodnam);
    $("#addStock_form .textadjust").val("");
    $(".btnmod").css("visibility", "hidden");
    dbOperations("", "add_operation", data, ["product_name", "stock"], ["#product-list", ".pro-item .product_name", prodnam]);
    $(".createloadgif").css("visibility", "visible");
    $('.outputmod').css("display", "inline");
}

function addToInvoicePrimer() {
    $.get("./assets/php/getProduct.php", function (response) {
        //var json = "";
        if (response != "") {
            json = JSON.parse(response);
            str = "<option value='' disabled selected hidden>select Drug</option>";
            for (var u = 0; u < json.length; u++) {
                str += '<option " class = "drug text-center" qty = '+ json[u].stock +'  rprice = '+ json[u].product_retailprice +'  wprice = '+ json[u].product_wholesaleprice +' value="' + json[u].product_name + '">' + json[u].product_name + '</option>';
            }
            $(".productlist").html(str);
        }
    });
}
function selproduct(sel){
    $('.qtyavailable').val($('option:selected', sel).attr('qty'));
    $('.retailp').val($('option:selected', sel).attr('rprice'));
    $('.wholesalep').val($('option:selected', sel).attr('wprice'));
}
function addProductToInvoice($this) {
    data = $("#addproduct_form").serialize();
    data += "&invoiceno=" + $('.invnum').html() + "&class=Sales";
    data = data.replace(/[&]/g, "^");
    custnam = $(".customer_name.act").html();
    $("#inventorylist").css("opacity", "0");
    $(".btnmod").css("visibility", "hidden"); dbOperations("", "add_operation", data, ["customer_name", "inventory"], ["#inventorylist", ".pro-item .customer_name", custnam]);
    $(".createloadgif").css("visibility", "visible");
    $('.outputmod').css("display", "inline");
}


function updateProduct(str) {
    switch (str) {
        case "load":
            if ($("li.actparent")[0]) {
                $("[name=proname]").val(String($("li.actparent .product_name").html()));
                $("[name=proddescription]").val(String($("li.actparent .product_description").html()));
                $("[name=prodretailprice]").val(String($("li.actparent .product_retailprice").html()));
                $("[name=prodwholesaleprice]").val(String($("li.actparent .product_wholesaleprice").html()));
            }
            break;
        case "store":
            data = $("#updproduct_form :input").filter(function (index, element) {
                return $(element).attr('readonly') == undefined && $(element).val() != '';
            }).serialize();
            data += "&wherecol=" + String($("li.actparent .product_name").html()) + "&class=Product";
            console.log(data);
            data = data.replace(/[&]/g, "^");
            $(".btnmod").css("visibility", "hidden");
            dbOperations("", "update_operation", data, ["product_name", "stock"]);
            $(".createloadgif").css("visibility", "visible");
            $('.outputmod').css("display", "inline");
            break;
    }

}

function updatecustomer(str) {
    switch (str) {
        case "load":
            if ($("li.actparent")[0]) {
                $("[name=cust_name]").val(String($("li.actparent .customer_name").html()));
                $("[name=cust_email]").val(String($("li.actparent .customer_email").html()));
                $("[name=cust_phone]").val(String($("li.actparent .customer_phone").html()));
                $("[name=cust_address]").val(String($("li.actparent .address").html()));
            }
            break;
        case "store":
            data = $("#updcustomer_form :input").filter(function (index, element) {
                return $(element).attr('readonly') == undefined && $(element).val() != '';
            }).serialize();
            data += "&wherecol=" + String($("li.actparent .customer_name").html()) + "&class=Customer";
            console.log(data);
            data = data.replace(/[&]/g, "^");
            $(".btnmod").css("visibility", "hidden");
            dbOperations("", "update_operation", data, ["customer_name", "inventory"]);
            $(".createloadgif").css("visibility", "visible");
            $('.outputmod').css("display", "inline");
            break;
    }

}

function updateStock(str) {
    switch (str) {
        case "load":
            if ($(".stktb tr.actparent")[0]) {
                $("#updateStock [name=entrdate]").val(String($("tr.actparent .edate").html()));
                $("#updateStock [name=stocno]").val(String($("tr.actparent .stkq").html()));
                $("#updateStock [name=expd]").val(String($(".stockdisp .expdt").html()));
            }
            break;
        case "store":
            data = $("#updstock_form :input").filter(function (index, element) {
                return $(element).attr('readonly') == undefined && $(element).val() != '';
            }).serialize();
            console.log($("tr.actparent .myid").html());
            data += "&oldexp=" + String($(".stockdisp .expdt").html());
            data += "&frmqty=" + String($("tr.actparent .stkq").html());
            data += "&wherecol=" + String($("tr.actparent .myid").html()) + "&class=Stock";
            console.log(data);
            data = data.replace(/[&]/g, "^");
            prodnam = $(".product_name.act").html();
            $("#product-list").css("opacity", "0");
            $(".btnmod").css("visibility", "hidden");
            dbOperations("", "update_operation", data, ["product_name", "stock"], ["#product-list", ".pro-item .product_name", prodnam]);
            $(".createloadgif").css("visibility", "visible");
            $('.outputmod').css("display", "inline");
            break;
    }

}

function updateStock(str) {
    switch (str) {
        case "load":
            if ($(".stktb tr.actparent")[0]) {
                $("#updateStock [name=entrdate]").val(String($("tr.actparent .edate").html()));
                $("#updateStock [name=stocno]").val(String($("tr.actparent .stkq").html()));
                $("#updateStock [name=expd]").val(String($(".stockdisp .expdt").html()));
            }
            break;
        case "store":
            data = $("#updstock_form :input").filter(function (index, element) {
                return $(element).attr('readonly') == undefined && $(element).val() != '';
            }).serialize();
            console.log($("tr.actparent .myid").html());
            data += "&oldexp=" + String($(".stockdisp .expdt").html());
            data += "&frmqty=" + String($("tr.actparent .stkq").html());
            data += "&wherecol=" + String($("tr.actparent .myid").html()) + "&class=Stock";
            console.log(data);
            data = data.replace(/[&]/g, "^");
            prodnam = $(".product_name.act").html();
            $("#product-list").css("opacity", "0");
            $(".btnmod").css("visibility", "hidden");
            dbOperations("", "update_operation", data, ["product_name", "stock"], ["#product-list", ".pro-item .product_name", prodnam]);
            $(".createloadgif").css("visibility", "visible");
            $('.outputmod').css("display", "inline");
            break;
    }

}

function debtpayment(str) {
    switch (str) {
        case "load":
            $("#debtpayment [name=debt_read]").val(String($("#inventorylist tr:last .invoiceoutbal").html()));
            break;
        case "store":
            $("#debtpayment [name=paidamt]").val() == "" ? $("#debtpayment [name=paidamt]").val(0) : null;
            data = $("#debtpayment_form :input").serialize();
            data += "&cust=" + String($("li.actparent .customer_name").html()) + "&adminref=" + String($(".adminref").text()) + "&class=Inventory";
            console.log(data);
            data = data.replace(/[&]/g, "^");
            custnam = $(".customer_name.act").html();
            $("#inventorylist").css("opacity", "0");
            $(".btnmod").css("visibility", "hidden"); dbOperations("", "update_operation", data, ["customer_name", "inventory"], ["#inventorylist", ".pro-item .customer_name", custnam]);

            $(".createloadgif").css("visibility", "visible");
            $('.outputmod').css("display", "inline");
            break;
    }

}

function updateCustomerInventory(str) {
    switch (str) {
        case "load":
            if ($(".cust_invdetails_tb tr.actparent")[0]) {
                $("#updateCustomerInventory [name=proname]").val(String($("tr.actparent .salesproduct").html()));
                $("#updateCustomerInventory [name=qty]").val(String($("tr.actparent .salesqty").html()));
            }
            break;
        case "store":
            data = $("#updateCustomerInventory :input").filter(function (index, element) {
                return $(element).attr('readonly') == undefined && $(element).val() != '';
            }).serialize();
            console.log(data);
            console.log($("tr.actparent .id").html());
            /* data += "&id=" + String($("tr.actparent .id").html()); */
            data += "&wherecol=" + String($("tr.actparent .id").html()) + "&class=Sales";
            console.log(data);
            data = data.replace(/[&]/g, "^");
            custnam = $(".customer_name.act").html();
            $("#inventorylist").css("opacity", "0");
            dbOperations("", "update_operation", data, ["customer_name", "inventory"], ["#inventorylist", ".pro-item .customer_name", custnam]);
            $(".btnmod").css("visibility", "hidden");
            $(".createloadgif").css("visibility", "visible");
            $('.outputmod').css("display", "inline");
            break;
    }

}


function modaltitlechg(modal_selector, newTitle) {
    $(modal_selector).html(String($(newTitle).html()));
}
