<table style="width: 100%;border-spacing: 0px !important;">
    <thead>
        <tr>
            <td style="text-align:left; width: 50%;">
                <img style="max-width: 120px;" src="{{ public_path('/storage/image/logo.gif')}}" />
            </td>
            <td style="text-align:right;font-weight:400; width: 50%;">
                <h5 style="
font-weight:600;
margin-bottom: 5px;
margin-top: 0px;
">
                    Order ID
                </h5>
                <span style="font-size: 12px;
margin-bottom: 0.5rem;
display: block;
">{{$order_id}}</span>
                <h5 style="
margin-bottom: 5px;
margin-top: 0px;
">
                    Order Date
                </h5>
                <span style="font-size: 12px;margin-bottom: 0.5rem;display: block;">{{ date('d/m/Y', strtotime($created_at))}}</span>
            </td>
        </tr>
        <tr>
            <td style="height:10px;"></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="height:12px;width: 50%;">
                <h5 style="font-weight:600;margin-bottom: 10px !important;">FROM</h5>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;
">
                    Shop : Zhop
                </p>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;
">
                    phone Number : 09692082635
                </p>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;
">
                    Email : saihtunlu14996@gmail.com
                </p>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;
">
                    Address : Street 1, One Road, Two Tsp, Yangon
                </p>
            </td>
            <td style="
text-align: right;width: 50%;
">
                <h5 style="font-weight:600;margin-bottom: 10px !important;">TO</h5>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;text-align: right;
">
                    Name : {{$userName}}
                </p>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;text-align: right;
">
                    phone Number : {{$phone}}
                </p>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;text-align: right;
">
                    Email : {{$email}}
                </p>
            </td>
        </tr>
        <tr>
            <td style="height:10px;"></td>
        </tr>
        <tr>
            <td style="height:12px;width: 50%;">
                <h5 style="font-weight:600;margin-bottom: 10px !important;">Order Detail</h5>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;
">
                    Payment Method : {{$payment_method}}
                </p>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;
">
                    Order Status : {{$status}}
                </p>
                @if($payment_method =='Bank Direct Transfer')
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;
">
                    @if((int)$paid == 0)
                    Paid : Not Yet
                    @else
                    Paid : Done
                    @endif
                </p>
                @endif
            </td>
            <td style="
text-align: right;width: 50%;
">
                <h5 style="font-weight:600;margin-bottom: 10px !important;">Shipping Address</h5>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;text-align: right;
">
                    State : {{$bill_address['state']}}
                </p>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;text-align: right;
">
                    City/Township : {{$bill_address['city']}}
                </p>
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;text-align: right;
">
                    Street Line 1 : {{$bill_address['addressLine1']}}
                </p>
                @if(!empty($bill_address['addressLine2']))
                <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;
">
                    Street Line 2 : {{$bill_address['addressLine2']}}
                </p>
                @endif
            </td>
        </tr>
        <tr>
            <td style="height:10px;"></td>
        </tr>
    </tbody>
</table>
<table style="width: 100%;">
    <thead>
        <tr>
            <td style="
font-weight:600;
padding: 0.5rem;
font-size: 12px;
background: #ececec;
border: 1px solid #ececec;
">
                Image
            </td>
            <td style="
font-weight:600;
padding: 0.5rem;
font-size: 12px;
background: #ececec;
border: 1px solid #ececec;
">
                Name
            </td>
            <td style="
font-weight:600;
padding: 0.5rem;
font-size: 12px;
background: #ececec;
border: 1px solid #ececec;
">
                QUANTITY
            </td>
            <td style="
font-weight:600;
padding: 0.5rem;
font-size: 12px;
background: #ececec;
border: 1px solid #ececec;
">
                PRICE
            </td>
            <td style="
font-weight:600;
padding: 0.5rem;
font-size: 12px;
background: #ececec;
border: 1px solid #ececec;
">
                TOTAL
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach ($detail as $item)
        <tr>

            @if($item['product_type'] =='Simple Product')

            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                <img style="max-width: 60px;" src="{{ public_path($item['product']['images'][0]['path'])}}" />
            </td>

            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                {{$item['product']['title']}}
            </td>
            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                {{$item['quantity']}}
            </td>
            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                @if(empty($item['product']['sale_price']))
                {{$item['product']['regular_price']}}Ks
                @else
                {{$item['product']['sale_price']}}Ks
                @endif
            </td>
            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                @if(empty($item['product']['sale_price']))
                {{(int)$item['product']['regular_price']*(int)$item['quantity']}}Ks
                @else
                {{(int)$item['product']['sale_price']*(int)$item['quantity']}}Ks
                @endif
            </td>
            @else
            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                <img style="max-width: 60px;" src="{{ public_path($item['variation']['image'])}}" />
            </td>

            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                @if(!empty($item['variation']['attri2']))
                {{$item['variation']['product']['title']}} - {{$item['variation']['attri1']['name']}} / {{$item['variation']['attri2']['name']}}
                @else
                {{$item['variation']['product']['title']}} - {{$item['variation']['attri1']['name']}}
                @endif
            </td>
            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                {{$item['quantity']}}
            </td>
            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                @if(empty($item['variation']['sale_price']))
                {{$item['variation']['regular_price']}}Ks
                @else
                {{$item['variation']['sale_price']}}Ks
                @endif
            </td>
            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                @if(empty($item['variation']['sale_price']))
                {{(int)$item['variation']['regular_price']*(int)$item['quantity']}}Ks
                @else
                {{(int)$item['variation']['sale_price']*(int)$item['quantity']}}Ks
                @endif
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
    <tbody>
        <tr>
            <td colspan="4" style="
font-weight:600;
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                Shipping Price
            </td>
            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                {{$shippingPrice}}Ks
            </td>
        </tr>
        <tr>
            <td colspan="4" style="
font-weight:600;
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                Tax %
            </td>
            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                5%
            </td>
        </tr>
        <tr>
            <td colspan="4" style="
font-weight:600;
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                GRAND TOTAL
            </td>
            <td style="
padding: 0.5rem;
font-size: 12px;
background: #fff;
border: 1px solid #ececec;
">
                {{$totalPrice}}Ks
            </td>
        </tr>
        <tr>
            <td style="height:10px;"></td>
        </tr>
    </tbody>
</table>
<table style="width: 100%;">
    <tbody>
        <tr>
            <td>
                @if($payment_method =='Bank Direct Transfer')
                <h5 style="font-weight:600;margin-bottom: 10px !important;">BANK INFORMATION</h5>
                @foreach ($payment['banks'] as $bank)
                <div style="border-radius:10px;width:80%;border:1px solid #ececec;padding:10px;margin-bottom:10px;">
                    <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;
">
                        Bank Name : {{$bank['bankName']}}
                    </p>
                    <p style="
margin-top: 0px !important;
margin-bottom: 10px !important;
font-size: 12px;
">
                        Account Holder : {{$bank['holderName']}}
                    </p>
                    <p style="
margin-top: 0px !important;
margin-bottom: 0px !important;
font-size: 12px;
">
                        Account Number : {{$bank['accNumber']}}
                    </p>
                </div>
                @endforeach
                @endif
            </td>
            <td style="
text-align:right;
">
                <div style="text-align:center;">
                    <img style="max-width: 100px; margin-top:1.5rem;" src="{{public_path('/storage/image/sign.png')}}" />
                    <p style="text-align:center;font-size: 12px; margin-bottom:0px;">Signature</p>
                </div>
            </td>
        </tr>
    </tbody>
</table>