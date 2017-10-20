<?php
namespace Database\Seeds\Doctrine;

use Illuminate\Database\Seeder;
use Doctrine\ORM\EntityManagerInterface;
use App\Entities\Pais;
use App\WithEntityManagerInterface;

class PaisesSeeder extends Seeder
{
    use WithEntityManagerInterface;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paises = <<<EOF
1,Afghanistan
2,Albania
3,Algeria
4,American Samoa
5,Andorra
6,Angola
7,Anguilla
8,Antarctica
9,Antigua And Barbuda
10,Argentina
11,Armenia
12,Aruba
13,Australia
14,Austria
15,Azerbaijan
16,Bahamas The
17,Bahrain
18,Bangladesh
19,Barbados
20,Belarus
21,Belgium
22,Belize
23,Benin
24,Bermuda
25,Bhutan
26,Bolivia
27,Bosnia and Herzegovina
28,Botswana
29,Bouvet Island
30,Brazil
31,British Indian Ocean Territory
32,Brunei
33,Bulgaria
34,Burkina Faso
35,Burundi
36,Cambodia
37,Cameroon
38,Canada
39,Cape Verde
40,Cayman Islands
41,Central African Republic
42,Chad
43,Chile
44,China
45,Christmas Island
46,Cocos (Keeling) Islands
47,Colombia
48,Comoros
49,Congo
50,Congo The Democratic Republic Of The
51,Cook Islands
52,Costa Rica
53,Cote D'Ivoire (Ivory Coast)
54,Croatia (Hrvatska)
55,Cuba
56,Cyprus
57,Czech Republic
58,Denmark
59,Djibouti
60,Dominica
61,Dominican Republic
62,East Timor
63,Ecuador
64,Egypt
65,El Salvador
66,Equatorial Guinea
67,Eritrea
68,Estonia
69,Ethiopia
70,External Territories of Australia
71,Falkland Islands
72,Faroe Islands
73,Fiji Islands
74,Finland
75,France
76,French Guiana
77,French Polynesia
78,French Southern Territories
79,Gabon
80,Gambia The
81,Georgia
82,Germany
83,Ghana
84,Gibraltar
85,Greece
86,Greenland
87,Grenada
88,Guadeloupe
89,Guam
90,Guatemala
91,Guernsey and Alderney
92,Guinea
93,Guinea-Bissau
94,Guyana
95,Haiti
96,Heard and McDonald Islands
97,Honduras
98,Hong Kong S.A.R.
99,Hungary
100,Iceland
101,India
102,Indonesia
103,Iran
104,Iraq
105,Ireland
106,Israel
107,Italy
108,Jamaica
109,Japan
110,Jersey
111,Jordan
112,Kazakhstan
113,Kenya
114,Kiribati
115,Korea North
116,Korea South
117,Kuwait
118,Kyrgyzstan
119,Laos
120,Latvia
121,Lebanon
122,Lesotho
123,Liberia
124,Libya
125,Liechtenstein
126,Lithuania
127,Luxembourg
128,Macau S.A.R.
129,Macedonia
130,Madagascar
131,Malawi
132,Malaysia
133,Maldives
134,Mali
135,Malta
136,Man (Isle of)
137,Marshall Islands
138,Martinique
139,Mauritania
140,Mauritius
141,Mayotte
142,Mexico
143,Micronesia
144,Moldova
145,Monaco
146,Mongolia
147,Montserrat
148,Morocco
149,Mozambique
150,Myanmar
151,Namibia
152,Nauru
153,Nepal
154,Netherlands Antilles
155,Netherlands The
156,New Caledonia
157,New Zealand
158,Nicaragua
159,Niger
160,Nigeria
161,Niue
162,Norfolk Island
163,Northern Mariana Islands
164,Norway
165,Oman
166,Pakistan
167,Palau
168,Palestinian Territory Occupied
169,Panama
170,Papua new Guinea
171,Paraguay
172,Peru
173,Philippines
174,Pitcairn Island
175,Poland
176,Portugal
177,Puerto Rico
178,Qatar
179,Reunion
180,Romania
181,Russia
182,Rwanda
183,Saint Helena
184,Saint Kitts And Nevis
185,Saint Lucia
186,Saint Pierre and Miquelon
187,Saint Vincent And The Grenadines
188,Samoa
189,San Marino
190,Sao Tome and Principe
191,Saudi Arabia
192,Senegal
193,Serbia
194,Seychelles
195,Sierra Leone
196,Singapore
197,Slovakia
198,Slovenia
199,Smaller Territories of the UK
200,Solomon Islands
201,Somalia
202,South Africa
203,South Georgia
204,South Sudan
205,Spain
206,Sri Lanka
207,Sudan
208,Suriname
209,Svalbard And Jan Mayen Islands
210,Swaziland
211,Sweden
212,Switzerland
213,Syria
214,Taiwan
215,Tajikistan
216,Tanzania
217,Thailand
218,Togo
219,Tokelau
220,Tonga
221,Trinidad And Tobago
222,Tunisia
223,Turkey
224,Turkmenistan
225,Turks And Caicos Islands
226,Tuvalu
227,Uganda
228,Ukraine
229,United Arab Emirates
230,United Kingdom
231,United States
232,United States Minor Outlying Islands
233,Uruguay
234,Uzbekistan
235,Vanuatu
236,Vatican City State (Holy See)
237,Venezuela
238,Vietnam
239,Virgin Islands (British)
240,Virgin Islands (US)
241,Wallis And Futuna Islands
242,Western Sahara
243,Yemen
244,Yugoslavia
245,Zambia
246,Zimbabwe
EOF;
        foreach (explode("\n", $paises) as $registro) {
            $partes = explode(",", $registro);
            $pais = new Pais();
            $pais->setId($partes[0]);
            $pais->setNome($partes[1]);
            $this->em->persist($pais);
        }
        $this->em->flush();
    }
}
