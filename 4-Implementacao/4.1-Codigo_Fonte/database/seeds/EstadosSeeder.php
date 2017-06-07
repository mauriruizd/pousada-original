<?php

use Illuminate\Database\Seeder;
use App\Entities\Estado;
use App\Entities\Pais;

use App\WithEntityManagerInterface;

class EstadosSeeder extends Seeder
{
    use WithEntityManagerInterface;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = <<<EOF
1,Andaman and Nicobar Islands,101
2,Andhra Pradesh,101
3,Arunachal Pradesh,101
4,Assam,101
5,Bihar,101
6,Chandigarh,101
7,Chhattisgarh,101
8,Dadra and Nagar Haveli,101
9,Daman and Diu,101
10,Delhi,101
11,Goa,101
12,Gujarat,101
13,Haryana,101
14,Himachal Pradesh,101
15,Jammu and Kashmir,101
16,Jharkhand,101
17,Karnataka,101
18,Kenmore,101
19,Kerala,101
20,Lakshadweep,101
21,Madhya Pradesh,101
22,Maharashtra,101
23,Manipur,101
24,Meghalaya,101
25,Mizoram,101
26,Nagaland,101
27,Narora,101
28,Natwar,101
29,Odisha,101
30,Paschim Medinipur,101
31,Pondicherry,101
32,Punjab,101
33,Rajasthan,101
34,Sikkim,101
35,Tamil Nadu,101
36,Telangana,101
37,Tripura,101
38,Uttar Pradesh,101
39,Uttarakhand,101
40,Vaishali,101
41,West Bengal,101
42,Badakhshan,1
43,Badgis,1
44,Baglan,1
45,Balkh,1
46,Bamiyan,1
47,Farah,1
48,Faryab,1
49,Gawr,1
50,Gazni,1
51,Herat,1
52,Hilmand,1
53,Jawzjan,1
54,Kabul,1
55,Kapisa,1
56,Khawst,1
57,Kunar,1
58,Lagman,1
59,Lawghar,1
60,Nangarhar,1
61,Nimruz,1
62,Nuristan,1
63,Paktika,1
64,Paktiya,1
65,Parwan,1
66,Qandahar,1
67,Qunduz,1
68,Samangan,1
69,Sar-e Pul,1
70,Takhar,1
71,Uruzgan,1
72,Wardag,1
73,Zabul,1
74,Berat,2
75,Bulqize,2
76,Delvine,2
77,Devoll,2
78,Dibre,2
79,Durres,2
80,Elbasan,2
81,Fier,2
82,Gjirokaster,2
83,Gramsh,2
84,Has,2
85,Kavaje,2
86,Kolonje,2
87,Korce,2
88,Kruje,2
89,Kucove,2
90,Kukes,2
91,Kurbin,2
92,Lezhe,2
93,Librazhd,2
94,Lushnje,2
95,Mallakaster,2
96,Malsi e Madhe,2
97,Mat,2
98,Mirdite,2
99,Peqin,2
100,Permet,2
101,Pogradec,2
102,Puke,2
103,Sarande,2
104,Shkoder,2
105,Skrapar,2
106,Tepelene,2
107,Tirane,2
108,Tropoje,2
109,Vlore,2
110,'Ayn Daflah,3
111,'Ayn Tamushanat,3
112,Adrar,3
113,Algiers,3
114,Annabah,3
115,Bashshar,3
116,Batnah,3
117,Bijayah,3
118,Biskrah,3
119,Blidah,3
120,Buirah,3
121,Bumardas,3
122,Burj Bu Arririj,3
123,Ghalizan,3
124,Ghardayah,3
125,Ilizi,3
126,Jijili,3
127,Jilfah,3
128,Khanshalah,3
129,Masilah,3
130,Midyah,3
131,Milah,3
132,Muaskar,3
133,Mustaghanam,3
134,Naama,3
135,Oran,3
136,Ouargla,3
137,Qalmah,3
138,Qustantinah,3
139,Sakikdah,3
140,Satif,3
141,Sayda',3
142,Sidi ban-al-'Abbas,3
143,Suq Ahras,3
144,Tamanghasat,3
145,Tibazah,3
146,Tibissah,3
147,Tilimsan,3
148,Tinduf,3
149,Tisamsilt,3
150,Tiyarat,3
151,Tizi Wazu,3
152,Umm-al-Bawaghi,3
153,Wahran,3
154,Warqla,3
155,Wilaya d Alger,3
156,Wilaya de Bejaia,3
157,Wilaya de Constantine,3
158,al-Aghwat,3
159,al-Bayadh,3
160,al-Jaza'ir,3
161,al-Wad,3
162,ash-Shalif,3
163,at-Tarif,3
164,Eastern,4
165,Manu'a,4
166,Swains Island,4
167,Western,4
168,Andorra la Vella,5
169,Canillo,5
170,Encamp,5
171,La Massana,5
172,Les Escaldes,5
173,Ordino,5
174,Sant Julia de Loria,5
175,Bengo,6
176,Benguela,6
177,Bie,6
178,Cabinda,6
179,Cunene,6
180,Huambo,6
181,Huila,6
182,Kuando-Kubango,6
183,Kwanza Norte,6
184,Kwanza Sul,6
185,Luanda,6
186,Lunda Norte,6
187,Lunda Sul,6
188,Malanje,6
189,Moxico,6
190,Namibe,6
191,Uige,6
192,Zaire,6
193,Other Provinces,7
194,Sector claimed by Argentina/Ch,8
195,Sector claimed by Argentina/UK,8
196,Sector claimed by Australia,8
197,Sector claimed by France,8
198,Sector claimed by New Zealand,8
199,Sector claimed by Norway,8
200,Unclaimed Sector,8
201,Barbuda,9
202,Saint George,9
203,Saint John,9
204,Saint Mary,9
205,Saint Paul,9
206,Saint Peter,9
207,Saint Philip,9
208,Buenos Aires,10
209,Catamarca,10
210,Chaco,10
211,Chubut,10
212,Cordoba,10
213,Corrientes,10
214,Distrito Federal,10
215,Entre Rios,10
216,Formosa,10
217,Jujuy,10
218,La Pampa,10
219,La Rioja,10
220,Mendoza,10
221,Misiones,10
222,Neuquen,10
223,Rio Negro,10
224,Salta,10
225,San Juan,10
226,San Luis,10
227,Santa Cruz,10
228,Santa Fe,10
229,Santiago del Estero,10
230,Tierra del Fuego,10
231,Tucuman,10
232,Aragatsotn,11
233,Ararat,11
234,Armavir,11
235,Gegharkunik,11
236,Kotaik,11
237,Lori,11
238,Shirak,11
239,Stepanakert,11
240,Syunik,11
241,Tavush,11
242,Vayots Dzor,11
243,Yerevan,11
244,Aruba,12
245,Auckland,13
246,Australian Capital Territory,13
247,Balgowlah,13
248,Balmain,13
249,Bankstown,13
250,Baulkham Hills,13
251,Bonnet Bay,13
252,Camberwell,13
253,Carole Park,13
254,Castle Hill,13
255,Caulfield,13
256,Chatswood,13
257,Cheltenham,13
258,Cherrybrook,13
259,Clayton,13
260,Collingwood,13
261,Frenchs Forest,13
262,Hawthorn,13
263,Jannnali,13
264,Knoxfield,13
265,Melbourne,13
266,New South Wales,13
267,Northern Territory,13
268,Perth,13
269,Queensland,13
270,South Australia,13
271,Tasmania,13
272,Templestowe,13
273,Victoria,13
274,Werribee south,13
275,Western Australia,13
276,Wheeler,13
277,Bundesland Salzburg,14
278,Bundesland Steiermark,14
279,Bundesland Tirol,14
280,Burgenland,14
281,Carinthia,14
282,Karnten,14
283,Liezen,14
284,Lower Austria,14
285,Niederosterreich,14
286,Oberosterreich,14
287,Salzburg,14
288,Schleswig-Holstein,14
289,Steiermark,14
290,Styria,14
291,Tirol,14
292,Upper Austria,14
293,Vorarlberg,14
294,Wien,14
295,Abseron,15
296,Baki Sahari,15
297,Ganca,15
298,Ganja,15
299,Kalbacar,15
300,Lankaran,15
301,Mil-Qarabax,15
302,Mugan-Salyan,15
303,Nagorni-Qarabax,15
304,Naxcivan,15
305,Priaraks,15
306,Qazax,15
307,Saki,15
308,Sirvan,15
309,Xacmaz,15
310,Abaco,16
311,Acklins Island,16
312,Andros,16
313,Berry Islands,16
314,Biminis,16
315,Cat Island,16
316,Crooked Island,16
317,Eleuthera,16
318,Exuma and Cays,16
319,Grand Bahama,16
320,Inagua Islands,16
321,Long Island,16
322,Mayaguana,16
323,New Providence,16
324,Ragged Island,16
325,Rum Cay,16
326,San Salvador,16
327,'Isa,17
328,Badiyah,17
329,Hidd,17
330,Jidd Hafs,17
331,Mahama,17
332,Manama,17
333,Sitrah,17
334,al-Manamah,17
335,al-Muharraq,17
336,ar-Rifa'a,17
337,Bagar Hat,18
338,Bandarban,18
339,Barguna,18
340,Barisal,18
341,Bhola,18
342,Bogora,18
343,Brahman Bariya,18
344,Chandpur,18
345,Chattagam,18
346,Chittagong Division,18
347,Chuadanga,18
348,Dhaka,18
349,Dinajpur,18
350,Faridpur,18
351,Feni,18
352,Gaybanda,18
353,Gazipur,18
354,Gopalganj,18
355,Habiganj,18
356,Jaipur Hat,18
357,Jamalpur,18
358,Jessor,18
359,Jhalakati,18
360,Jhanaydah,18
361,Khagrachhari,18
362,Khulna,18
363,Kishorganj,18
364,Koks Bazar,18
365,Komilla,18
366,Kurigram,18
367,Kushtiya,18
368,Lakshmipur,18
369,Lalmanir Hat,18
370,Madaripur,18
371,Magura,18
372,Maimansingh,18
373,Manikganj,18
374,Maulvi Bazar,18
375,Meherpur,18
376,Munshiganj,18
377,Naral,18
378,Narayanganj,18
379,Narsingdi,18
380,Nator,18
381,Naugaon,18
382,Nawabganj,18
383,Netrakona,18
384,Nilphamari,18
385,Noakhali,18
386,Pabna,18
387,Panchagarh,18
388,Patuakhali,18
389,Pirojpur,18
390,Rajbari,18
391,Rajshahi,18
392,Rangamati,18
393,Rangpur,18
394,Satkhira,18
395,Shariatpur,18
396,Sherpur,18
397,Silhat,18
398,Sirajganj,18
399,Sunamganj,18
400,Tangayal,18
401,Thakurgaon,18
402,Christ Church,19
403,Saint Andrew,19
404,Saint George,19
405,Saint James,19
406,Saint John,19
407,Saint Joseph,19
408,Saint Lucy,19
409,Saint Michael,19
410,Saint Peter,19
411,Saint Philip,19
412,Saint Thomas,19
413,Brest,20
414,Homjel',20
415,Hrodna,20
416,Mahiljow,20
417,Mahilyowskaya Voblasts,20
418,Minsk,20
419,Minskaja Voblasts',20
420,Petrik,20
421,Vicebsk,20
422,Antwerpen,21
423,Berchem,21
424,Brabant,21
425,Brabant Wallon,21
426,Brussel,21
427,East Flanders,21
428,Hainaut,21
429,Liege,21
430,Limburg,21
431,Luxembourg,21
432,Namur,21
433,Ontario,21
434,Oost-Vlaanderen,21
435,Provincie Brabant,21
436,Vlaams-Brabant,21
437,Wallonne,21
438,West-Vlaanderen,21
439,Belize,22
440,Cayo,22
441,Corozal,22
442,Orange Walk,22
443,Stann Creek,22
444,Toledo,22
445,Alibori,23
446,Atacora,23
447,Atlantique,23
448,Borgou,23
449,Collines,23
450,Couffo,23
451,Donga,23
452,Littoral,23
453,Mono,23
454,Oueme,23
455,Plateau,23
456,Zou,23
457,Hamilton,24
458,Saint George,24
459,Bumthang,25
460,Chhukha,25
461,Chirang,25
462,Daga,25
463,Geylegphug,25
464,Ha,25
465,Lhuntshi,25
466,Mongar,25
467,Pemagatsel,25
468,Punakha,25
469,Rinpung,25
470,Samchi,25
471,Samdrup Jongkhar,25
472,Shemgang,25
473,Tashigang,25
474,Timphu,25
475,Tongsa,25
476,Wangdiphodrang,25
477,Beni,26
478,Chuquisaca,26
479,Cochabamba,26
480,La Paz,26
481,Oruro,26
482,Pando,26
483,Potosi,26
484,Santa Cruz,26
485,Tarija,26
486,Federacija Bosna i Hercegovina,27
487,Republika Srpska,27
488,Central Bobonong,28
489,Central Boteti,28
490,Central Mahalapye,28
491,Central Serowe-Palapye,28
492,Central Tutume,28
493,Chobe,28
494,Francistown,28
495,Gaborone,28
496,Ghanzi,28
497,Jwaneng,28
498,Kgalagadi North,28
499,Kgalagadi South,28
500,Kgatleng,28
EOF;
        foreach (explode("\n", $estados) as $registro) {
            $partes = explode(",", $registro);
            $estado = new Estado();
            $estado->setId($partes[0]);
            $estado->setNome($partes[1]);
            $estado->setPais($this->em->getRepository('App\Entities\Pais')->find($partes[2]));
            $this->em->persist($estado);
        }
        $this->em->flush();
    }
}
