<!DOCTYPE html>
<html>
<head>
    <title></title>

    <!-- Ignite UI Required Combined CSS Files -->
    <link href="http://cdn-na.infragistics.com/igniteui/2015.2/latest/css/themes/infragistics/infragistics.theme.css" rel="stylesheet" />
    <link href="http://cdn-na.infragistics.com/igniteui/2015.2/latest/css/structure/infragistics.css" rel="stylesheet" />

    <script src="http://ajax.aspnetcdn.com/ajax/modernizr/modernizr-2.8.3.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>

    <!-- Ignite UI Required Combined JavaScript Files -->
    <script src="http://cdn-na.infragistics.com/igniteui/2015.2/latest/js/infragistics.core.js"></script>
    <script src="http://cdn-na.infragistics.com/igniteui/2015.2/latest/js/infragistics.lob.js"></script>

</head>
<body>

    <table id="grid"></table>

    <script>
        $(function () {

              var northwindProducts = [
    { "ProductID": 1, "ProductName": "Chai", "CategoryName": "Beverages", "ImageUrl": "../../images/samples/nw/categories/1.png", "InStock": 39 },
    { "ProductID": 2, "ProductName": "Chang", "CategoryName": "Beverages", "ImageUrl": "../../images/samples/nw/categories/1.png", "InStock": 17 },
    { "ProductID": 3, "ProductName": "Aniseed Syrup", "CategoryName": "Condiments", "ImageUrl": "../../images/samples/nw/categories/2.png", "InStock": 13 },
    { "ProductID": 4, "ProductName": "Chef Anton\u0027s Cajun Seasoning", "CategoryName": "Condiments", "ImageUrl": "../../images/samples/nw/categories/2.png", "InStock": 53 },
    { "ProductID": 5, "ProductName": "Chef Anton\u0027s Gumbo Mix", "CategoryName": "Condiments", "ImageUrl": "../../images/samples/nw/categories/2.png", "InStock": 0 },
    { "ProductID": 6, "ProductName": "Grandma\u0027s Boysenberry Spread", "CategoryName": "Condiments", "ImageUrl": "../../images/samples/nw/categories/2.png", "InStock": 120 },
    { "ProductID": 7, "ProductName": "Uncle Bob\u0027s Organic Dried Pears", "CategoryName": "Produce", "ImageUrl": "../../images/samples/nw/categories/7.png", "InStock": 15 },
    { "ProductID": 8, "ProductName": "Northwoods Cranberry Sauce", "CategoryName": "Condiments", "ImageUrl": "../../images/samples/nw/categories/2.png", "InStock": 6 },
    { "ProductID": 9, "ProductName": "Mishi Kobe Niku", "CategoryName": "Meat/Poultry", "ImageUrl": "../../images/samples/nw/categories/6.png", "InStock": 29 },
    { "ProductID": 10, "ProductName": "Ikura", "CategoryName": "Seafood", "ImageUrl": "../../images/samples/nw/categories/8.png", "InStock": 31 },
    { "ProductID": 11, "ProductName": "Queso Cabrales", "CategoryName": "Dairy Products", "ImageUrl": "../../images/samples/nw/categories/4.png", "InStock": 22 },
    { "ProductID": 12, "ProductName": "Queso Manchego La Pastora", "CategoryName": "Dairy Products", "ImageUrl": "../../images/samples/nw/categories/4.png", "InStock": 86 },
    { "ProductID": 13, "ProductName": "Konbu", "CategoryName": "Seafood", "ImageUrl": "../../images/samples/nw/categories/8.png", "InStock": 24 },
    { "ProductID": 14, "ProductName": "Tofu", "CategoryName": "Produce", "ImageUrl": "../../images/samples/nw/categories/7.png", "InStock": 35 },
    { "ProductID": 15, "ProductName": "Genen Shouyu", "CategoryName": "Condiments", "ImageUrl": "../../images/samples/nw/categories/2.png", "InStock": 39 },
    { "ProductID": 16, "ProductName": "Pavlova", "CategoryName": "Confections", "ImageUrl": "../../images/samples/nw/categories/3.png", "InStock": 29 },
    { "ProductID": 17, "ProductName": "Alice Mutton", "CategoryName": "Meat/Poultry", "ImageUrl": "../../images/samples/nw/categories/6.png", "InStock": 0 },
    { "ProductID": 18, "ProductName": "Carnarvon Tigers", "CategoryName": "Seafood", "ImageUrl": "../../images/samples/nw/categories/8.png", "InStock": 42 },
    { "ProductID": 19, "ProductName": "Teatime Chocolate Biscuits", "CategoryName": "Confections", "ImageUrl": "../../images/samples/nw/categories/3.png", "InStock": 25 },
    { "ProductID": 20, "ProductName": "Sir Rodney\u0027s Marmalade", "CategoryName": "Confections", "ImageUrl": "../../images/samples/nw/categories/3.png", "InStock": 40 },
    { "ProductID": 21, "ProductName": "Sir Rodney\u0027s Scones", "CategoryName": "Confections", "ImageUrl": "../../images/samples/nw/categories/3.png", "InStock": 3 },
    { "ProductID": 22, "ProductName": "Gustaf\u0027s Knäckebröd", "CategoryName": "Grains/Cereals", "ImageUrl": "../../images/samples/nw/categories/5.png", "InStock": 104 },
    { "ProductID": 23, "ProductName": "Tunnbröd", "CategoryName": "Grains/Cereals", "ImageUrl": "../../images/samples/nw/categories/5.png", "InStock": 61 },
    { "ProductID": 24, "ProductName": "Guaraná Fantástica", "CategoryName": "Beverages", "ImageUrl": "../../images/samples/nw/categories/1.png", "InStock": 20 },
    { "ProductID": 25, "ProductName": "NuNuCa Nuß-Nougat-Creme", "CategoryName": "Confections", "ImageUrl": "../../images/samples/nw/categories/3.png", "InStock": 76 },
    { "ProductID": 26, "ProductName": "Gumbär Gummibärchen", "CategoryName": "Confections", "ImageUrl": "../../images/samples/nw/categories/3.png", "InStock": 15 },
    { "ProductID": 27, "ProductName": "Schoggi Schokolade", "CategoryName": "Confections", "ImageUrl": "../../images/samples/nw/categories/3.png", "InStock": 49 },
    { "ProductID": 28, "ProductName": "Rössle Sauerkraut", "CategoryName": "Produce", "ImageUrl": "../../images/samples/nw/categories/7.png", "InStock": 26 },
    { "ProductID": 29, "ProductName": "Thüringer Rostbratwurst", "CategoryName": "Meat/Poultry", "ImageUrl": "../../images/samples/nw/categories/6.png", "InStock": 0 },
    { "ProductID": 30, "ProductName": "Nord-Ost Matjeshering", "CategoryName": "Seafood", "ImageUrl": "../../images/samples/nw/categories/8.png", "InStock": 10 }
];
  
            for (var i = 0; i < northwindProducts.length; i++) {
                northwindProducts[i].ImageUrl = "http://lorempixel.com/50/50/food/" + (i % 10) + "/";
            }
            $("#grid").igGrid({
                primaryKey: "ProductID",
                width: '100%',
                columns: [
                    { headerText: "Product ID", key: "ProductID", dataType: "number", width: "15%", hidden: true },
                    { headerText: "Image", key: "ImageUrl", dataType: "string", width: "15%", template: "<img src=\"${ImageUrl}\"/>" },
                    { headerText: "Product Name", key: "ProductName", dataType: "string", width: "25%" },
                    { headerText: "Category", key: "CategoryName", dataType: "string", width: "25%" },
                    { headerText: "Units In Stock", key: "InStock", dataType: "number", width: "35%" }
                ],
                autofitLastColumn: false,
                autoGenerateColumns: false,
                dataSource: northwindProducts,
                responseDataKey: "results",
                autoCommit: true,
                features: [
                    {
                        name: "Sorting",
                        sortingDialogContainment: "window"
                    },
                    {
                        name: "Filtering",
                        type: "local",
                        columnSettings: [
                            {
                                columnKey: "ImageUrl",
                                allowFiltering: false
                            },
                            {
                                columnKey: "InStock",
                                condition: "greaterThan"
                            }
                        ]
                    },
                    {
                        name: "GroupBy",
                        columnSettings: [
                            {
                                columnKey: "CategoryName",
                                isGroupBy: true
                            }
                        ]
                    },
                    {
                        name: "Selection"
                    },
                    {
                        name: "Paging",
                        pageSize: 10
                    },
                    {
                        name: "Resizing"
                    },
                    {
                        name: "Updating",
                        editMode: "dialog",
                        enableAddRow: false,
                        columnSettings: [
                            {
                                columnKey: "ImageUrl",
                                readOnly: false
                            }
                        ]
                    }
                ]
            });
        });
     </script>
</body>
</html>