
function getTimeStamp() {
    var date = new Date();
    return date.getTime();
}

function getUrlParameter(fieldName) {
    var urlString = document.location.search;
    if (urlString != null) {
        var typeQu = fieldName + "=";
        var urlEnd = urlString.indexOf(typeQu);
        if (urlEnd != -1) {
            var paramsUrl = urlString.substring(urlEnd + typeQu.length);
            var isEnd = paramsUrl.indexOf('&');
            if (isEnd != -1) {
                return paramsUrl.substring(0, isEnd);
            }
            else {
                return paramsUrl;
            }
        }
        else {
            return null;
        }
    }
    else {
        return null;
    }
}


function getRestUrlParameter(){
    var urlString = document.location.href;
    var index = urlString.lastIndexOf('/');
    if(+index > -1){
        var dealIdText = urlString.substring(index + 1,urlString.length);
        return dealIdText.replace(/[^0-9]+/,"");
    }else{
        return '';
    }

}



function synTimeFromServer() {
    var url = "#" + getTimeStamp();
    $.getJSON(url, function (response) {
        if (response.now != undefined) {
            updateNow(response.now);
        }
    });
}

function loadBidRecord(dealId, pageNo, pageSize) {
    var url = "#" + getTimeStamp();
    var page = pageNo || 1;
    var size = pageSize || 8;
    var data = {dealId:dealId || getRestUrlParameter(), pageNo:page, pageSize:size};
    $.getJSON(url, data, function (response) {
        bidRecords = response.datas;
        var buyerName = response.trxBuyerName;
        var trxPrice = response.trxPrice;
        var status = response.auctionStatus;
        var totalBidNumber = response.totalItem||bidRecords.length ;
        var first = bidRecords[0];

        if (status == null || status == undefined) {
            status = dealModel['auctionStatus'];
        }
        if (status != null) {
            dealModel['auctionStatus'] = status;
        }

        if (!!first) {
            var curPrice = "<strong class='ftx-01'>￥" + first.price.toFixed(2) + "</strong>";
            $("#cur_price").html(curPrice);
            $("#buyerName").html(userNicknameCompressor((first.userShowname || first.userNickName))||'无人');
        }

        //超过8条显示更多按钮
        if((+totalBidNumber) > 8){
            $('#bidRecordMoreDiv').show();
        }else{
            $('#bidRecordMoreDiv').hide();
        }

    });
}
var dealModel={init_price:1.0,startTimeMili:1407740340000,endTimeMili:1407812342000};
dealModel['auctionStatus']=1;

function isDealStarted(time) {
    if (dealModel.auctionStatus == 1) {
        return true;
    }
}
