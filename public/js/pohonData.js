//column nilai =>arrVarCol
const arrVarCol = [
    ['Muda', 'Dewasa', 'Tua'],
    ['Miopi', 'Hipermetropi'],
    ['Tidak Silinder', 'Silinder'],
    ['Air Mata Berkurang', 'Normal'],
]

var pohon = {};
let gainTampung = [];
let arrPohon = [];

function lognX(n, x) {
    const c = Math.log(x)/Math.log(n);
    return c;
}
function entropy(data) {
    let total = 0, s1 = 0, s2 = 0, s3 = 0;
    let partisi = [];
    let ent = 0;

    for (let i=0;i<data.length;i++) {
        if (data[i][data[i].length-1]=='Soft Lens') {
            s2++;
        }
        if (data[i][data[i].length-1]=='Hard Lens') {
            s1++;
        }
        if (data[i][data[i].length-1]=='Tanpa Kontak Lensa') {
            s3++;
        }
        total++
    }
    partisi = [s1, s2, s3];

    for (let i=0;i<partisi.length;i++) {
        if (partisi[i]!=0) {
            ent += (-1*(partisi[i]/total))*lognX(2, partisi[i]/total);
        }
    }
    return ent;
}

function gain(data, j, nilai) {
    let partisi = {};
    let gain = 0, ent = [], entAkhir = 0;

    for (let i=0;i<nilai.length;i++) {
        partisi[nilai[i]] = [0, 0, 0, 0];
        ent[i] = 0;
    }

    for (let i=0;i<data.length;i++) {
        for (let n=0;n<nilai.length;n++) {
            if (data[i][j]==nilai[n]) {
                if (data[i][data[i].length-1]=='Soft Lens') {
                    ++partisi[`${nilai[n]}`][1];
                    ++partisi[`${nilai[n]}`][3];
                }
                if (data[i][data[i].length-1]=='Hard Lens') {
                    ++partisi[`${nilai[n]}`][0];
                    ++partisi[`${nilai[n]}`][3];
                }
                if (data[i][data[i].length-1]=='Tanpa Kontak Lensa') {
                    ++partisi[`${nilai[n]}`][2];
                    ++partisi[`${nilai[n]}`][3];
                }
            }
        }
    }

    for (let i=0;i<nilai.length;i++) {
        if (partisi[`${nilai[i]}`][0]!=0 && partisi[`${nilai[i]}`][1]!=0 && partisi[`${nilai[i]}`][2]!=0) {
            ent[i] += (-1*(partisi[`${nilai[i]}`][0]/partisi[`${nilai[i]}`][3]))*
            lognX(2, partisi[`${nilai[i]}`][0]/partisi[`${nilai[i]}`][3]);
            ent[i] += (-1*(partisi[`${nilai[i]}`][1]/partisi[`${nilai[i]}`][3]))*
            lognX(2, partisi[`${nilai[i]}`][1]/partisi[`${nilai[i]}`][3]);
            ent[i] += (-1*(partisi[`${nilai[i]}`][2]/partisi[`${nilai[i]}`][3]))*
            lognX(2, partisi[`${nilai[i]}`][2]/partisi[`${nilai[i]}`][3]);
        } else {
            if (partisi[`${nilai[i]}`][0]!=0 && partisi[`${nilai[i]}`][1]!=0) {
                ent[i] += (-1*(partisi[`${nilai[i]}`][0]/partisi[`${nilai[i]}`][3]))*
                lognX(2, partisi[`${nilai[i]}`][0]/partisi[`${nilai[i]}`][3]);
                ent[i] += (-1*(partisi[`${nilai[i]}`][1]/partisi[`${nilai[i]}`][3]))*
                lognX(2, partisi[`${nilai[i]}`][1]/partisi[`${nilai[i]}`][3]);
            }
            if (partisi[`${nilai[i]}`][0]!=0 && partisi[`${nilai[i]}`][2]!=0) {
                ent[i] += (-1*(partisi[`${nilai[i]}`][0]/partisi[`${nilai[i]}`][3]))*
                lognX(2, partisi[`${nilai[i]}`][0]/partisi[`${nilai[i]}`][3]);
                ent[i] += (-1*(partisi[`${nilai[i]}`][2]/partisi[`${nilai[i]}`][3]))*
                lognX(2, partisi[`${nilai[i]}`][2]/partisi[`${nilai[i]}`][3]);
            }
            if (partisi[`${nilai[i]}`][1]!=0 && partisi[`${nilai[i]}`][2]!=0) {
                ent[i] += (-1*(partisi[`${nilai[i]}`][1]/partisi[`${nilai[i]}`][3]))*
                lognX(2, partisi[`${nilai[i]}`][1]/partisi[`${nilai[i]}`][3]);
                ent[i] += (-1*(partisi[`${nilai[i]}`][2]/partisi[`${nilai[i]}`][3]))*
                lognX(2, partisi[`${nilai[i]}`][2]/partisi[`${nilai[i]}`][3]);
            }
        }
    }

    for (let i=0;i<nilai.length;i++) {
        entAkhir += (partisi[`${nilai[i]}`][3]/data.length)*ent[i];
    }

    gain = entropy(data)-entAkhir;

    return gain;
}

const gains = (i) => {
    if (i>=arrVarCol.length) {
        return;
    }else {
        gainTampung[i] = gain(arr, i, arrVarCol[i]);
        gains(i+1);
    }
}

function nodePohon() {
    let tamp;
    let arrBaru = [];
    
    for (let i=0;i<gainTampung.length;i++) {
        arrBaru[i] = gainTampung[i];
    }

    for (let i=0;i<arrBaru.length;i++) {
        for (let j=arrBaru.length-1;j>=i;j--) {
            if (arrBaru[j]<arrBaru[i]) {
                tamp = arrBaru[j];
                arrBaru[j] = arrBaru[i];
                arrBaru[i] = tamp;
            }
        }
    }

    for (let i=0;i<gainTampung.length;i++) {
        if (gainTampung[i]==arrBaru[arrBaru.length-1]) {
            return i;
        }
    }    
}

function cabang(col, arrLama, obj) {
    if (arrLama.length!=0) {
        if (obj==null) {
            pohon[col] = {};
        } else {
            obj[col] = {};
        }
        let arrBaru = [];
        let iBaru = 0;
        let colNilai = {};
        let pilihRoot;

        for (let i=0;i<arrVarCol[col].length;i++) {
            colNilai[`${arrVarCol[col][i]}`] = [0, 0, 0, 0];
        }
        for (let i=0;i<arrLama.length;i++) {
            for (let j=0;j<arrVarCol[col].length;j++) {
                if (arrLama[i][col]==arrVarCol[col][j]) {
                    if (arrLama[i][arrLama[i].length-1]=='Hard Lens') {
                        ++colNilai[`${arrVarCol[col][j]}`][0];
                        ++colNilai[`${arrVarCol[col][j]}`][3];
                    }
                    if (arrLama[i][arrLama[i].length-1]=='Soft Lens') {
                        ++colNilai[`${arrVarCol[col][j]}`][1];
                        ++colNilai[`${arrVarCol[col][j]}`][3];
                    }
                    if (arrLama[i][arrLama[i].length-1]=='Tanpa Kontak Lensa') {
                        ++colNilai[`${arrVarCol[col][j]}`][2];
                        ++colNilai[`${arrVarCol[col][j]}`][3];
                    }
                }
            }
        }

        for (let i=0;i<arrVarCol[col].length;i++) {
            if (colNilai[`${arrVarCol[col][i]}`][0]!=0 && colNilai[`${arrVarCol[col][i]}`][1]!=0 && colNilai[`${arrVarCol[col][i]}`][2]!=0) {
                pilihRoot = arrVarCol[col][i];
            } else {
                if (colNilai[`${arrVarCol[col][i]}`][0]!=0 && colNilai[`${arrVarCol[col][i]}`][1]!=0) {
                    // if (i==entCabang.length-1) {
                        pilihRoot = arrVarCol[col][i];
                    // }
                }
                if (colNilai[`${arrVarCol[col][i]}`][0]!=0 && colNilai[`${arrVarCol[col][i]}`][2]!=0) {
                    // if (i==entCabang.length-1) {
                        pilihRoot = arrVarCol[col][i];
                    // }
                }
                if (colNilai[`${arrVarCol[col][i]}`][1]!=0 && colNilai[`${arrVarCol[col][i]}`][2]!=0) {
                    // if (i==entCabang.length-1) {
                        pilihRoot = arrVarCol[col][i];
                    // }
                }
            }
        }

        for (let i=0;i<arr.length;i++) {
            if (arr[i][col]==pilihRoot) {
                arrBaru[iBaru++] = arr[i];
            }
        }

        for (let i=0;i<arrVarCol[col].length;i++) {
            if (colNilai[`${arrVarCol[col][i]}`][0]==0 && colNilai[`${arrVarCol[col][i]}`][1]==0) {
                if (obj==null) {
                    pohon[col][`${arrVarCol[col][i]}`] = 'Tanpa Kontak Lensa';
                    if (col==0) {
                        arrPohon.push([arrVarCol[col][i], 'Usia', 'Tanpa Kontak Lensa']);
                        // arrPohon.push([arrVarCol[col][i], 'Usia']);
                        // arrPohon.push(['Tanpa Kontak Lensa', arrVarCol[col][i]]);
                    }
                    if (col==1) {
                        arrPohon.push([arrVarCol[col][i], 'Jenis Rabun', 'Tanpa Kontak Lensa']);
                        // arrPohon.push([arrVarCol[col][i], 'Jenis Rabun']);
                        // arrPohon.push(['Tanpa Kontak Lensa', arrVarCol[col][i]]);
                    }
                    if (col==2) {
                        arrPohon.push([arrVarCol[col][i], 'Astigmatism', 'Tanpa Kontak Lensa']);
                        // arrPohon.push([arrVarCol[col][i], 'Astigmatism']);
                        // arrPohon.push(['Tanpa Kontak Lensa', arrVarCol[col][i]]);
                    }
                    if (col==3) {
                        arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata', 'Tanpa Kontak Lensa']);
                        // arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata']);
                        // arrPohon.push(['Tanpa Kontak Lensa', arrVarCol[col][i]]);
                    }
                } else {
                    obj[col][`${arrVarCol[col][i]}`] = 'Tanpa Kontak Lensa';
                    if (col==0) {
                        arrPohon.push([arrVarCol[col][i], 'Usia', 'Tanpa Kontak Lensa']);
                        // arrPohon.push([arrVarCol[col][i], 'Usia']);
                        // arrPohon.push(['Tanpa Kontak Lensa', arrVarCol[col][i]]);
                    }
                    if (col==1) {
                        arrPohon.push([arrVarCol[col][i], 'Jenis Rabun', 'Tanpa Kontak Lensa']);
                        // arrPohon.push([arrVarCol[col][i], 'Jenis Rabun']);
                        // arrPohon.push(['Tanpa Kontak Lensa', arrVarCol[col][i]]);
                    }
                    if (col==2) {
                        arrPohon.push([arrVarCol[col][i], 'Astigmatism', 'Tanpa Kontak Lensa']);
                        // arrPohon.push([arrVarCol[col][i], 'Astigmatism']);
                        // arrPohon.push(['Tanpa Kontak Lensa', arrVarCol[col][i]]);
                    }
                    if (col==3) {
                        arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata', 'Tanpa Kontak Lensa']);
                        // arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata']);
                        // arrPohon.push(['Tanpa Kontak Lensa', arrVarCol[col][i]]);
                    }
                }
            }
            if (colNilai[`${arrVarCol[col][i]}`][0]==0 && colNilai[`${arrVarCol[col][i]}`][2]==0) {
                if (obj==null) {
                    pohon[col][`${arrVarCol[col][i]}`] = 'Soft Lens';
                    if (col==0) {
                        arrPohon.push([arrVarCol[col][i], 'Usia', 'Soft Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Usia']);
                        // arrPohon.push(['Soft Lens', arrVarCol[col][i]]);
                    }
                    if (col==1) {
                        arrPohon.push([arrVarCol[col][i], 'Jenis Rabun', 'Soft Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Jenis Rabun']);
                        // arrPohon.push(['Soft Lens', arrVarCol[col][i]]);
                    }
                    if (col==2) {
                        arrPohon.push([arrVarCol[col][i], 'Astigmatism', 'Soft Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Astigmatism']);
                        // arrPohon.push(['Soft Lens', arrVarCol[col][i]]);
                    }
                    if (col==3) {
                        arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata', 'Soft Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata']);
                        // arrPohon.push(['Soft Lens', arrVarCol[col][i]]);
                    }
                } else {
                    obj[col][`${arrVarCol[col][i]}`] = 'Soft Lens';
                    if (col==0) {
                        arrPohon.push([arrVarCol[col][i], 'Usia', 'Soft Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Usia']);
                        // arrPohon.push(['Soft Lens', arrVarCol[col][i]]);
                    }
                    if (col==1) {
                        arrPohon.push([arrVarCol[col][i], 'Jenis Rabun', 'Soft Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Jenis Rabun']);
                        // arrPohon.push(['Soft Lens', arrVarCol[col][i]]);
                    }
                    if (col==2) {
                        arrPohon.push([arrVarCol[col][i], 'Astigmatism', 'Soft Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Astigmatism']);
                        // arrPohon.push(['Soft Lens', arrVarCol[col][i]]);
                    }
                    if (col==3) {
                        arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata', 'Soft Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata']);
                        // arrPohon.push(['Soft Lens', arrVarCol[col][i]]);
                    }
                }
            }
            if (colNilai[`${arrVarCol[col][i]}`][1]==0 && colNilai[`${arrVarCol[col][i]}`][2]==0) {
                if (obj==null) {
                    pohon[col][`${arrVarCol[col][i]}`] = 'Hard Lens';
                    if (col==0) {
                        arrPohon.push([arrVarCol[col][i], 'Usia', 'Hard Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Usia']);
                        // arrPohon.push(['Hard Lens', arrVarCol[col][i]]);
                    }
                    if (col==1) {
                        arrPohon.push([arrVarCol[col][i], 'Jenis Rabun', 'Hard Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Jenis Rabun']);
                        // arrPohon.push(['Hard Lens', arrVarCol[col][i]]);
                    }
                    if (col==2) {
                        arrPohon.push([arrVarCol[col][i], 'Astigmatism', 'Hard Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Astigmatism']);
                        // arrPohon.push(['Hard Lens', arrVarCol[col][i]]);
                    }
                    if (col==3) {
                        arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata', 'Hard Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata']);
                        // arrPohon.push(['Hard Lens', arrVarCol[col][i]]);
                    }
                } else {
                    obj[col][`${arrVarCol[col][i]}`] = 'Hard Lens';
                    if (col==0) {
                        arrPohon.push([arrVarCol[col][i], 'Usia', 'Hard Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Usia']);
                        // arrPohon.push(['Hard Lens', arrVarCol[col][i]]);
                    }
                    if (col==1) {
                        arrPohon.push([arrVarCol[col][i], 'Jenis Rabun', 'Hard Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Jenis Rabun']);
                        // arrPohon.push(['Hard Lens', arrVarCol[col][i]]);
                    }
                    if (col==2) {
                        arrPohon.push([arrVarCol[col][i], 'Astigmatism', 'Hard Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Astigmatism']);
                        // arrPohon.push(['Hard Lens', arrVarCol[col][i]]);
                    }
                    if (col==3) {
                        arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata', 'Hard Lens']);
                        // arrPohon.push([arrVarCol[col][i], 'Tingkat Produksi Air Mata']);
                        // arrPohon.push(['Hard Lens', arrVarCol[col][i]]);
                    }
                }
            }
        }
        arr = arrBaru;

        if (obj==null) {
            return pohon[col][pilihRoot] = {};
        } else {
            if (typeof(pilihRoot)==='undefined') {
                return;
            }
            return obj[col][pilihRoot] = {};
        }
    } else {
        return -1;
    }
}

function bentukPohon(z=null, y=null) {
    if (z==-1) {
        return
    } else {
        let ujiVar = '', nilaiUji = '';
        gains(0);
        if (nodePohon()==0) {
            ujiVar = 'Usia';
        }
        if (nodePohon()==1) {
            ujiVar = 'Jenis Rabun';
        }
        if (nodePohon()==2) {
            ujiVar = 'Astigmatism';
        }
        if (nodePohon()==3) {
            ujiVar = 'Tingkat Produksi Air Mata';
        }
        // console.log(nodePohon());
        if (y==null) {
            arrPohon.push([ujiVar, '', '']);
        }
        if (typeof(nodePohon())!='undefined' && y!=null) {
            if (y==0) {
                nilaiUji = 'Usia';
            }
            if (y==1) {
                nilaiUji = 'Jenis Rabun';
            }
            if (y==2) {
                nilaiUji = 'Astigmatism';
            }
            if (y==3) {
                nilaiUji = 'Tingkat Produksi Air Mata';
            }
            arrPohon.push([ujiVar, nilaiUji, '']);
        }
        let cab = nodePohon();
        let x = cabang(nodePohon(), arr, z);

        bentukPohon(x, cab);
    }
}

if (arr.length!=0) {
    setTimeout(bentukPohon(), 2000);
    console.log(pohon);
}

// console.log(arrPohon);
// console.log(pohon[3]);
// console.log(pohon[3][2][2][2]);
    // <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
google.charts.load('current', {packages:["orgchart"]});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Anak');
    data.addColumn('string', 'Root');
    // data.addColumn('string', 'Nilai');

    // For each orgchart box, provide the name, manager, and tooltip to show.

    for (let i=0;i<=arrPohon.length-1;i++) {
        data.addRow([
            {
                'v':`${arrPohon[i][0]}`,
                'f':`${arrPohon[i][0]}<div class="pohonUji">${arrPohon[i][2]}</div>`
            },
            `${arrPohon[i][1]}`
        ])
        // console.log(arrPohon[i])
    }
    // data.addRows([
    //     [{'v':'Mike', 'f':'Mike<div style="color:red; font-style:italic">President</div>'},
    //     '', 'The President'],
    //     [{'v':'Jim', 'f':'Jim<div style="color:red; font-style:italic">Vice President</div>'},
    //     'Mike', 'VP'],
    //     ['Alice', 'Mike', ''],
    //     ['Bob', 'Jim', 'Bob Sponge'],
    //     ['Carol', 'Bob', '']
    // ]);

    // Create the chart.
    var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
    // Draw the chart, setting the allowHtml option to true for the tooltips.
    chart.draw(data, {'allowHtml':true});
}
