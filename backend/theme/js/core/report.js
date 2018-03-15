function csv(filename, data) {
    var fileName = filename;
    /*Initialize file format you want csv or xls*/
    var uri = 'data:text/csv;charset=utf-8,' + escape(data);
    var link = document.createElement("a");
    link.href = uri;
    /*set the visibility hidden so it will not effect on your web-layout*/
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    /*this part will append the anchor tag and remove it after automatic click*/
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}


