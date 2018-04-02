@extends('layouts.front')

@section('page-title')
    Dashboard
@endsection

@section('front-content')

    <p>You are logged in!</p>
    <p>Welcome to the dashboard</p>

    <p>Semantic UI component testing</p>

    <button class="ui button right floated">
        <i class="fa fa-calendar"></i>
        Right
    </button>

    <button class="ui button red right floated">
        Red
    </button>

    <button class="ui primary button">
        Tester
    </button>

    <button class="ui basic primary button">
        Tester
    </button>

    <button class="ui secondary button">
        Tester
    </button>

    <button class="ui loading button">Loading</button>

    <div class="ui search">
      <div class="ui icon input">
        <input class="prompt" type="text" placeholder="Search countries...">
        <i class="search icon"></i>
      </div>
    </div>

<div class="ui labeled button" tabindex="0">
  <div class="ui button">
    <i class="heart icon"></i> Like
  </div>
  <a class="ui basic label">
    2,048
  </a>
</div>

<div class="ui left labeled button" tabindex="0">
  <a class="ui basic right pointing label">
    2,048
  </a>
  <div class="ui button">
    <i class="heart icon"></i> Like
  </div>
</div>

<button class="ui icon button">
  <i class="cloud icon"></i>
</button>

<div class="ui icon input loading">
  <input type="text" placeholder="Search...">
  <i class="search icon"></i>
</div>

<div class="row">
    <div class="ui input error">
        <input type="text" placeholder="Search...">
    </div>
</div>

<div class="ui left corner labeled input">
  <input type="text" placeholder="Search...">
  <div class="ui left corner label">
    <i class="asterisk icon"></i>
  </div>
</div>

<br>

<div class="ui fluid icon input">
  <input type="text" placeholder="Search small...">
  <i class="search icon"></i>
</div>

<p>Label</p>
<div class="ui label">
  <i class="mail icon"></i> 23
</div>

<a class="ui tag label">New</a>
<a class="ui red tag label">Upcoming</a>
<a class="ui teal tag label">Featured</a>


<div class="ui two column grid">
  <div class="column">
    <div class="ui raised segment">
      <a class="ui red ribbon label">Overview</a>
      <span>Account Details</span>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur saepe iste sunt, reiciendis ea neque molestiae, libero quisquam optio, aspernatur architecto modi ipsum iusto maxime? Sint eaque cupiditate odit placeat.</p>
      <a class="ui blue ribbon label">Community</a> User Reviews
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore consectetur aspernatur eius repudiandae quas odio facilis, ea minima libero non quod reiciendis dolorem deleniti itaque. Quaerat saepe et laudantium id.</p>
    </div>
  </div>
  <div class="column">
    <div class="ui segment">
      <a class="ui orange right ribbon label">Specs</a>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore rem nam nesciunt quidem magni quae, magnam illo, deserunt doloribus ipsum, quam quis molestiae. Enim obcaecati labore cum dolorem cupiditate ullam.</p>
      <a class="ui teal right ribbon label">Reviews</a>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores vero possimus ut. Mollitia laborum voluptas doloremque. Unde provident corrupti quibusdam architecto aperiam expedita enim consequatur, voluptates, odit nulla veniam dignissimos.</p>
    </div>
  </div>
</div>

<a class="ui red circular label">2</a>
<a class="ui circular label">2</a>

<div class="ui segments">
  <div class="ui segment">
    <p>Top</p>
  </div>
  <div class="ui secondary segment">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae excepturi sit velit cumque aperiam, animi mollitia enim recusandae, in possimus fugit! Id, sapiente non! Quibusdam tenetur unde soluta expedita sed?</p>
  </div>
</div>

<div class="ui raised segment">
  <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
</div>

<div class="ui ordered steps">
  <div class="completed step">
    <div class="content">
      <div class="title">Shipping</div>
      <div class="description">Choose your shipping options</div>
    </div>
  </div>
  <div class="completed step">
    <div class="content">
      <div class="title">Billing</div>
      <div class="description">Enter billing information</div>
    </div>
  </div>
  <div class="active step">
    <div class="content">
      <div class="title">Confirm Order</div>
      <div class="description">Verify order details</div>
    </div>
  </div>
</div>

<div class="ui steps">
  <div class="step">
    <i class="truck icon"></i>
    <div class="content">
      <div class="title">Shipping</div>
      <div class="description">Choose your shipping options</div>
    </div>
  </div>
</div>

<div class="ui breadcrumb">
  <a class="section">Home</a>
  <div class="divider"> / </div>
  <a class="section">Store</a>
  <div class="divider"> / </div>
  <div class="active section">T-Shirt</div>
</div>

<p>Forms</p>

<div class="ui form">
  <div class="inline field">
    <div class="ui checkbox">
      <input type="checkbox" tabindex="0" class="hidden">
      <label>Checkbox</label>
    </div>
  </div>
  <div class="inline field">
    <div class="ui slider checkbox">
      <input type="checkbox" tabindex="0" class="hidden">
      <label>Slider</label>
    </div>
    <label></label>
  </div>
  <div class="inline field">
    <div class="ui toggle checkbox">
      <input type="checkbox" tabindex="0" class="hidden">
      <label>Toggle</label>
    </div>
  </div>
</div>

<p>Dropdown</p>

<div class="ui form">
  <div class="field">
    <label>Country</label>
    <select class="ui search dropdown">
      <option value="">Select Country</option>
      <option value="AF">Afghanistan</option>
      <option value="AX">Åland Islands</option>
      <option value="AL">Albania</option>
      <option value="DZ">Algeria</option>
      <option value="AS">American Samoa</option>
      <option value="AD">Andorra</option>
      <option value="AO">Angola</option>
      <option value="AI">Anguilla</option>
      <option value="AQ">Antarctica</option>
      <option value="AG">Antigua and Barbuda</option>
      <option value="AR">Argentina</option>
      <option value="AM">Armenia</option>
      <option value="AW">Aruba</option>
      <option value="AU">Australia</option>
      <option value="AT">Austria</option>
      <option value="AZ">Azerbaijan</option>
      <option value="BS">Bahamas</option>
      <option value="BH">Bahrain</option>
      <option value="BD">Bangladesh</option>
      <option value="BB">Barbados</option>
      <option value="BY">Belarus</option>
      <option value="BE">Belgium</option>
      <option value="BZ">Belize</option>
      <option value="BJ">Benin</option>
      <option value="BM">Bermuda</option>
      <option value="BT">Bhutan</option>
      <option value="BO">Bolivia, Plurinational State of</option>
      <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
      <option value="BA">Bosnia and Herzegovina</option>
      <option value="BW">Botswana</option>
      <option value="BV">Bouvet Island</option>
      <option value="BR">Brazil</option>
      <option value="IO">British Indian Ocean Territory</option>
      <option value="BN">Brunei Darussalam</option>
      <option value="BG">Bulgaria</option>
      <option value="BF">Burkina Faso</option>
      <option value="BI">Burundi</option>
      <option value="KH">Cambodia</option>
      <option value="CM">Cameroon</option>
      <option value="CA">Canada</option>
      <option value="CV">Cape Verde</option>
      <option value="KY">Cayman Islands</option>
      <option value="CF">Central African Republic</option>
      <option value="TD">Chad</option>
      <option value="CL">Chile</option>
      <option value="CN">China</option>
      <option value="CX">Christmas Island</option>
      <option value="CC">Cocos (Keeling) Islands</option>
      <option value="CO">Colombia</option>
      <option value="KM">Comoros</option>
      <option value="CG">Congo</option>
      <option value="CD">Congo, the Democratic Republic of the</option>
      <option value="CK">Cook Islands</option>
      <option value="CR">Costa Rica</option>
      <option value="CI">Côte d'Ivoire</option>
      <option value="HR">Croatia</option>
      <option value="CU">Cuba</option>
      <option value="CW">Curaçao</option>
      <option value="CY">Cyprus</option>
      <option value="CZ">Czech Republic</option>
      <option value="DK">Denmark</option>
      <option value="DJ">Djibouti</option>
      <option value="DM">Dominica</option>
      <option value="DO">Dominican Republic</option>
      <option value="EC">Ecuador</option>
      <option value="EG">Egypt</option>
      <option value="SV">El Salvador</option>
      <option value="GQ">Equatorial Guinea</option>
      <option value="ER">Eritrea</option>
      <option value="EE">Estonia</option>
      <option value="ET">Ethiopia</option>
      <option value="FK">Falkland Islands (Malvinas)</option>
      <option value="FO">Faroe Islands</option>
      <option value="FJ">Fiji</option>
      <option value="FI">Finland</option>
      <option value="FR">France</option>
      <option value="GF">French Guiana</option>
      <option value="PF">French Polynesia</option>
      <option value="TF">French Southern Territories</option>
      <option value="GA">Gabon</option>
      <option value="GM">Gambia</option>
      <option value="GE">Georgia</option>
      <option value="DE">Germany</option>
      <option value="GH">Ghana</option>
      <option value="GI">Gibraltar</option>
      <option value="GR">Greece</option>
      <option value="GL">Greenland</option>
      <option value="GD">Grenada</option>
      <option value="GP">Guadeloupe</option>
      <option value="GU">Guam</option>
      <option value="GT">Guatemala</option>
      <option value="GG">Guernsey</option>
      <option value="GN">Guinea</option>
      <option value="GW">Guinea-Bissau</option>
      <option value="GY">Guyana</option>
      <option value="HT">Haiti</option>
      <option value="HM">Heard Island and McDonald Islands</option>
      <option value="VA">Holy See (Vatican City State)</option>
      <option value="HN">Honduras</option>
      <option value="HK">Hong Kong</option>
      <option value="HU">Hungary</option>
      <option value="IS">Iceland</option>
      <option value="IN">India</option>
      <option value="ID">Indonesia</option>
      <option value="IR">Iran, Islamic Republic of</option>
      <option value="IQ">Iraq</option>
      <option value="IE">Ireland</option>
      <option value="IM">Isle of Man</option>
      <option value="IL">Israel</option>
      <option value="IT">Italy</option>
      <option value="JM">Jamaica</option>
      <option value="JP">Japan</option>
      <option value="JE">Jersey</option>
      <option value="JO">Jordan</option>
      <option value="KZ">Kazakhstan</option>
      <option value="KE">Kenya</option>
      <option value="KI">Kiribati</option>
      <option value="KP">Korea, Democratic People's Republic of</option>
      <option value="KR">Korea, Republic of</option>
      <option value="KW">Kuwait</option>
      <option value="KG">Kyrgyzstan</option>
      <option value="LA">Lao People's Democratic Republic</option>
      <option value="LV">Latvia</option>
      <option value="LB">Lebanon</option>
      <option value="LS">Lesotho</option>
      <option value="LR">Liberia</option>
      <option value="LY">Libya</option>
      <option value="LI">Liechtenstein</option>
      <option value="LT">Lithuania</option>
      <option value="LU">Luxembourg</option>
      <option value="MO">Macao</option>
      <option value="MK">Macedonia, the former Yugoslav Republic of</option>
      <option value="MG">Madagascar</option>
      <option value="MW">Malawi</option>
      <option value="MY">Malaysia</option>
      <option value="MV">Maldives</option>
      <option value="ML">Mali</option>
      <option value="MT">Malta</option>
      <option value="MH">Marshall Islands</option>
      <option value="MQ">Martinique</option>
      <option value="MR">Mauritania</option>
      <option value="MU">Mauritius</option>
      <option value="YT">Mayotte</option>
      <option value="MX">Mexico</option>
      <option value="FM">Micronesia, Federated States of</option>
      <option value="MD">Moldova, Republic of</option>
      <option value="MC">Monaco</option>
      <option value="MN">Mongolia</option>
      <option value="ME">Montenegro</option>
      <option value="MS">Montserrat</option>
      <option value="MA">Morocco</option>
      <option value="MZ">Mozambique</option>
      <option value="MM">Myanmar</option>
      <option value="NA">Namibia</option>
      <option value="NR">Nauru</option>
      <option value="NP">Nepal</option>
      <option value="NL">Netherlands</option>
      <option value="NC">New Caledonia</option>
      <option value="NZ">New Zealand</option>
      <option value="NI">Nicaragua</option>
      <option value="NE">Niger</option>
      <option value="NG">Nigeria</option>
      <option value="NU">Niue</option>
      <option value="NF">Norfolk Island</option>
      <option value="MP">Northern Mariana Islands</option>
      <option value="NO">Norway</option>
      <option value="OM">Oman</option>
      <option value="PK">Pakistan</option>
      <option value="PW">Palau</option>
      <option value="PS">Palestinian Territory, Occupied</option>
      <option value="PA">Panama</option>
      <option value="PG">Papua New Guinea</option>
      <option value="PY">Paraguay</option>
      <option value="PE">Peru</option>
      <option value="PH">Philippines</option>
      <option value="PN">Pitcairn</option>
      <option value="PL">Poland</option>
      <option value="PT">Portugal</option>
      <option value="PR">Puerto Rico</option>
      <option value="QA">Qatar</option>
      <option value="RE">Réunion</option>
      <option value="RO">Romania</option>
      <option value="RU">Russian Federation</option>
      <option value="RW">Rwanda</option>
      <option value="BL">Saint Barthélemy</option>
      <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
      <option value="KN">Saint Kitts and Nevis</option>
      <option value="LC">Saint Lucia</option>
      <option value="MF">Saint Martin (French part)</option>
      <option value="PM">Saint Pierre and Miquelon</option>
      <option value="VC">Saint Vincent and the Grenadines</option>
      <option value="WS">Samoa</option>
      <option value="SM">San Marino</option>
      <option value="ST">Sao Tome and Principe</option>
      <option value="SA">Saudi Arabia</option>
      <option value="SN">Senegal</option>
      <option value="RS">Serbia</option>
      <option value="SC">Seychelles</option>
      <option value="SL">Sierra Leone</option>
      <option value="SG">Singapore</option>
      <option value="SX">Sint Maarten (Dutch part)</option>
      <option value="SK">Slovakia</option>
      <option value="SI">Slovenia</option>
      <option value="SB">Solomon Islands</option>
      <option value="SO">Somalia</option>
      <option value="ZA">South Africa</option>
      <option value="GS">South Georgia and the South Sandwich Islands</option>
      <option value="SS">South Sudan</option>
      <option value="ES">Spain</option>
      <option value="LK">Sri Lanka</option>
      <option value="SD">Sudan</option>
      <option value="SR">Suriname</option>
      <option value="SJ">Svalbard and Jan Mayen</option>
      <option value="SZ">Swaziland</option>
      <option value="SE">Sweden</option>
      <option value="CH">Switzerland</option>
      <option value="SY">Syrian Arab Republic</option>
      <option value="TW">Taiwan, Province of China</option>
      <option value="TJ">Tajikistan</option>
      <option value="TZ">Tanzania, United Republic of</option>
      <option value="TH">Thailand</option>
      <option value="TL">Timor-Leste</option>
      <option value="TG">Togo</option>
      <option value="TK">Tokelau</option>
      <option value="TO">Tonga</option>
      <option value="TT">Trinidad and Tobago</option>
      <option value="TN">Tunisia</option>
      <option value="TR">Turkey</option>
      <option value="TM">Turkmenistan</option>
      <option value="TC">Turks and Caicos Islands</option>
      <option value="TV">Tuvalu</option>
      <option value="UG">Uganda</option>
      <option value="UA">Ukraine</option>
      <option value="AE">United Arab Emirates</option>
      <option value="GB">United Kingdom</option>
      <option value="US">United States</option>
      <option value="UM">United States Minor Outlying Islands</option>
      <option value="UY">Uruguay</option>
      <option value="UZ">Uzbekistan</option>
      <option value="VU">Vanuatu</option>
      <option value="VE">Venezuela, Bolivarian Republic of</option>
      <option value="VN">Viet Nam</option>
      <option value="VG">Virgin Islands, British</option>
      <option value="VI">Virgin Islands, U.S.</option>
      <option value="WF">Wallis and Futuna</option>
      <option value="EH">Western Sahara</option>
      <option value="YE">Yemen</option>
      <option value="ZM">Zambia</option>
      <option value="ZW">Zimbabwe</option>
    </select>
  </div>
</div>

<p>grid</p>
<div class="ui grid">
  <div class="four wide column">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quasi repellendus temporibus consectetur maiores reprehenderit, laudantium maxime aperiam amet autem tenetur aut quia blanditiis, nam, delectus accusantium numquam vitae perspiciatis omnis?</div>
  <div class="four wide column">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima quibusdam, fugiat eos quia distinctio dolores eum nostrum accusantium adipisci consequuntur perferendis officiis harum dolor in maxime aliquam quae nihil itaque?</div>
  <div class="four wide column"></div>
  <div class="four wide column"></div>
  <div class="four wide column"></div>
  <div class="four wide column"></div>
  <div class="four wide column">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos libero quaerat eius eaque est odio nostrum accusantium molestiae, unde cum a, quibusdam et tenetur ipsam voluptas sequi sapiente cumque aspernatur?</div>
  <div class="four wide column">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium, perferendis! Cumque adipisci consectetur, tenetur quaerat quasi odio recusandae ex id asperiores deleniti, nulla exercitationem sunt, aliquid maiores commodi voluptas minus.</div>
</div>

<p>Menu</p>

<div class="ui vertical pointing menu">
  <a class="item active">
    Home
  </a>
  <a class="item">
    Messages
  </a>
  <a class="item">
    Friends
  </a>
</div>

<div class="ui icon top left pointing dropdown button">
  <i class="wrench icon"></i>
  <div class="menu">
    <div class="header">Display Density</div>
    <div class="item">Comfortable</div>
    <div class="item">Cozy</div>
    <div class="item">Compact</div>
    <div class="ui divider"></div>
    <div class="item">Settings</div>
    <div class="item">
      <i class="dropdown icon"></i>
      <span class="text">Upload Settings</span>
      <div class="menu">
        <div class="item">
          <i class="check icon"></i>
          Convert Uploaded Files to PDF
        </div>
        <div class="item">
          <i class="check icon"></i>
          Digitize Text from Uploaded Files
        </div>
      </div>
    </div>
    <div class="item">Manage Apps</div>
    <div class="item">Keyboard Shortcuts</div>
    <div class="item">Help</div>
  </div>
</div>


@endsection

@section('scripts')
    <script>
    $('.ui.checkbox').checkbox();

    $('select.dropdown').dropdown();
    $('.ui.dropdown').dropdown();
  </script>
@stop