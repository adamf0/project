class FormProposalFactory {
    createShape(element,withClear=false,response,type,id=null,hideInput=true) {
        switch (type) {
        case 'internal':
            return new FormPenelitianInternal(element,withClear,response,id,hideInput);
        case 'pkm':
            return new FormPKM(element,withClear,response,id,hideInput);
        default:
            throw new Error('Invalid type form proposal factory');
        }
    }
}
class Template {
    draw() {
        throw new Error('Method not implemented');
    }
}
class FormPenelitianInternal extends Template {
    constructor(element,withClear,response,id_pdp,hideInput){
        super();
        this.element = element;
        this.withClear = withClear;
        this.response = response;
        this.id_pdp = id_pdp;
        this.hideInput = hideInput;
    }
    draw() {
        console.log(this.id_pdp)
        const responApi = this.response.data;
        const lengthStep = responApi.stepper.length        
        if(this.withClear) this.element.empty()

        let contentStepper = ``;
        responApi.stepper.forEach(function callback(value, index) {
            contentStepper += `<button class="nav-link circle-tab ${value.isActive? `active`:``}" id="step${index+1}-tab" data-bs-toggle="pill" data-bs-target="#step${index+1}" type="button" role="tab" aria-controls="step${index+1}" aria-selected="${value.isActive? 'true':'false'}" ${value.isDisable? `disabled`:``}>${value.numberStep}</button>`
            contentStepper += index==lengthStep-1? ``:`<div class="line"></div>`       
        })
        let contentAnggota = ``;
        responApi.listAnggota.forEach(function callback(value, index) {
            contentAnggota += `<tr>
                <td>${value.nidn??"-"}</td>
                <td>${value.nama??"-"} - ${value.prodi?.namaProdi??"-"} (${value.fakultas?.namaFakultas??"-"})</td>
            </tr>`       
        })
        let contentNonAnggota = ``;
        responApi.listNonAnggota.forEach((value, index) => {
            contentNonAnggota += `<tr>
                <td>
                    ${value.npm ?? "-"}
                    ${this.id_pdp != null ? `<input type="hidden" name="anggotaNonPeneliti[${index}][npm]" value="${value.npm}">`:""}
                </td>
                <td>${value.nama ?? "-"}</td>
                <td>
                    ${this.id_pdp != null ? (this.hideInput? `${value.bukti_mbkm??""}`:`<input type="text" name="anggotaNonPeneliti[${index}][bukti_mbkm]" class="form-control" value="${value.bukti_mbkm??""}"></td>`) : ""}
                </td>
            </tr>`;
        });
        let contentNonAnggota2 = ``;
        responApi.listNonAnggota2.forEach(function callback(value, index) {
            contentNonAnggota2 += `<tr>
                <td>${value.nomorIdentitas??"-"}</td>
                <td>${value.nama??"-"}</td>
                <td>${value.afiliasi??"-"}</td>
            </tr>`
        })
        let luaranTargetContent = ``;
        responApi.listLuaran.forEach(function callback(value, index) {
            console.log(value);
            luaranTargetContent += `<tr>
                <td>${index+1}</td>
                <td>${value.kategoriLaporan??"-"}</td>
                <td>${value.kategoriLuaran??"-"}</td>
                <td>${value.status??"-"}</td>
                <td>${value.keterangan??''}</td>
                <td>${value.link??''}</td>
            </tr>`
        })
        let rabContent = ``;
        let totalRab = 0;
        responApi.listRab.forEach(function callback(value, index) {
            const _item = value.item;
            const _harga_satuan = value.harga_satuan;
            const _total = value.harga_satuan==null || value.harga_satuan=="0" || value.harga_satuan==0? (value.total??0):((_item??0) * (_harga_satuan??0));
            totalRab += _total

            rabContent += `<tr>
                <td>${index+1}</td>
                <td>${value.kelompokRab??"-"}</td>
                <td>${value.komponen??"-"}</td>
                <td>${_item??"-"}</td>
                <td>${value.satuan??"-"}</td>
                <td>${_harga_satuan??"-"}</td>
                <td>${formatRupiah(`${_total}`, "Rp. ")}</td>
            </tr>`
        })
        rabContent += `<tr>
                <td class="text-end" colspan="6">Subtotal</td>
                <td>${formatRupiah(`${totalRab}`, "Rp. ")}</td>
            </tr>`
            
        let dokumenPendukung = ``;
        responApi.listDokumenPendukung.forEach(function callback(value, index) {
            let mitra = '';
            if(value.fileMitra?.fileName!=null){
                mitra = `<a href="${value.fileMitra.url}">${value.fileMitra.fileName}</a>`
            } else if(value.link!=null){
                mitra = `<a href="${value.link}">${value.link}</a>`
            }
            dokumenPendukung += `<tr>
                <td>${mitra}</td>
                <td>${value.kategori??"-"}</td>
            </tr>`
        })
        let dokumenKontrak = ``;
        responApi.listDokumenKontrak.forEach(function callback(value, index) {
            let file = `<a href="${value.url}">${value.file}</a>`;
            dokumenKontrak += `<tr>
                <td>${file}</td>
            </tr>`
        })

        let content = ` <div class="nav circle-tab-container mb-3" id="pills-tab" role="tablist">
                            ${contentStepper}
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="tab-content card" id="pills-tabContent">
                                        <div class="card-body tab-pane fade active show" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                                            <form action="https://sipaksi.unpak.ac.id/penelitianInternal/updateStep1" method="post">
                                                <input type="hidden" name="id_pdp" value="${this.id_pdp}">
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <h5 class="text-primary">1.1 Identitas Usulan Penelitian</h5>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            ${viewInput("Pengusul",(responApi.dosen?.nidn??"-")+" "+(responApi.dosen?.nama??"-")+" - "+(responApi.dosen?.prodi?.namaProdi??"-")+" ("+(responApi.dosen?.fakultas?.namaFakultas??"-")+")")}
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                            ${viewInput("Tahun Pengajuan",responApi.tahunPengajuan??"-")}
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                            ${viewInput("Judul",responApi.judul??"-")}
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                                ${viewInput("Kelompok Skema",responApi.skema??"-")}
                                                            </div>
                                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                                ${viewInput("TKT",responApi.tkt??"-")}
                                                            </div>
                                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                                ${viewInput("Kategori TKT",responApi.kategoriTkt??"-")}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <h5 class="text-primary">1.2 Pemilihan Program Penelitian</h5>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                                        ${viewInput("Bidang Fokus Penelitian",responApi.fokusPenelitian??"-")}
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                                        ${viewInput("Tema",responApi.tema??"-")}
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                                        ${viewInput("Topik",responApi.topik??"-")}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                                        ${viewInput("Rumpun Ilmu 1",responApi.rumpunIlmu1??"-")}
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                                        ${viewInput("Rumpun Ilmu 2",responApi.rumpunIlmu2??"-")}
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                                        ${viewInput("Rumpun Ilmu 3",responApi.rumpunIlmu3??"-")}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                                ${viewInput("Prioritas Riset",responApi.prioritasRiset??"-")}
                                                            </div>
                                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                                ${viewInput("Lama Kegiatan (bulan)",responApi.lamaKegiatan??"-")}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <h5 class="text-primary">1.4 Identitas Pengusul - Anggota Peneliti</h5>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                            <table id="tbAnggotaPeneliti" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>NIDN</th>
                                                                        <th>Nama</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    ${contentAnggota}  
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <h5 class="text-primary">1.5 Identitas Pengusul - Anggota Peneliti (Mahasiswa)</h5>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                            <table id="tbAnggotaPenelitiNonDosen" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>NPM</th>
                                                                        <th>Nama</th>
                                                                        <th>
                                                                            Bukti MBKM<br>
                                                                            <small>(Link google drive)</small>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    ${contentNonAnggota}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <h5 class="text-primary">1.6 Identitas Pengusul - Anggota Peneliti (Non Dosen Unpak / Non Dosen)</h5>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                            <table id="tbAnggotaPenelitiNonDosen2" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nomor Identitas</th>
                                                                        <th>Nama</th>
                                                                        <th>Afiliasi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    ${contentNonAnggota2}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between gap-2">
                                                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2"></div>
                                                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                                                        ${this.id_pdp!=null? `<button type="submit" class="btn btn-success">Update</button>`:``}
                                                        <button type="button" class="btn btn-primary" id="nextStep1">Lanjut</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-body tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <h5 class="text-primary">2.1 Substansi Usulan</h5>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <label class="form-label">Unggah Substansi Laporan</label><br>
                                                            <a href="${responApi.substansiLuaran?.url??"#"}">${responApi.substansiLuaran?.fileName??"-"}</a>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <h5 class="text-primary">2.2 Luaran Target Capaian</h5>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                            <table id="tbLuaran" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <td>#</td>
                                                                        <td>Kategori</td>
                                                                        <td>Luaran</td>
                                                                        <td>Status</td>
                                                                        <td>Keterangan</td>
                                                                        <td>Link</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="contentLuaran">
                                                                    ${luaranTargetContent}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between gap-2">
                                                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2"></div>
                                                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                                                        <button type="button" class="btn btn-secondary mr-2" id="prevStep2">Previous</button>
                                                        <button type="button" class="btn btn-primary" id="nextStep2">Lanjut</button>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="card-body tab-pane fade" id="step3" role="tabpanel" aria-labelledby="step3-tab">
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <h5 class="text-primary">3.1 Rencana Anggaran Biaya</h5>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                            <table id="tbRab" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <td>#</td>
                                                                        <td>Kelompok RAB</td>
                                                                        <td>Komponen</td>
                                                                        <td>Item</td>
                                                                        <td>Satuan</td>
                                                                        <td>Harga Satuan</td>
                                                                        <td>Total</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="contentRab">
                                                                    ${rabContent}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between gap-2">
                                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2"></div>
                                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                                                            <button type="button" class="btn btn-secondary mr-2" id="prevStep3">Previous</button>
                                                            <button type="button" class="btn btn-primary" id="nextStep3">Lanjut</button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="card-body tab-pane fade" id="step4" role="tabpanel" aria-labelledby="step4-tab">
                                                <div class="row">
                                                    <div class="row mt-2">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <h5 class="text-primary">4.1 Dokumen Pendukung (Jika Ada)</h5>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                            <table id="tbDokumenPendukung" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Mitra</th>
                                                                        <th>Kategori</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    ${dokumenPendukung}
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                            <h5 class="text-primary">4.2 Dokumen Kontrak</h5>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                            <table id="tbDokumenKontrak" class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>File</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    ${dokumenKontrak}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between gap-2">
                                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2"></div>
                                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                                                            <button type="button" class="btn btn-secondary mr-2" id="prevStep4">Previous</button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>`;

        this.element.append(content)

        const step1Tab = document.getElementById("step1-tab");
        const step2Tab = document.getElementById("step2-tab");
        const step3Tab = document.getElementById("step3-tab");
        const step4Tab = document.getElementById("step4-tab");

        $('#nextStep1').click(function(e) {
            e.preventDefault();
            step2Tab.removeAttribute("disabled");
            step2Tab.click();
        });
        $('#nextStep2').click(function(e) {
            e.preventDefault();
            step3Tab.removeAttribute("disabled");
            step3Tab.click();
        });
        $('#nextStep3').click(function(e) {
            e.preventDefault();
            step4Tab.removeAttribute("disabled");
            step4Tab.click();
        });

        $('#prevStep2').click(function(e){
            e.preventDefault();
            step1Tab.click();
        });
        $('#prevStep3').click(function(e) {
            e.preventDefault();
            step2Tab.click();
        });
        $('#prevStep4').click(function(e) {
            e.preventDefault();
            step3Tab.click();
        });
    }
}
class FormPKM extends Template {
    constructor(element,withClear,response,id_pkm,hideInput){
        super();
        this.element = element;
        this.withClear = withClear;
        this.response = response;
        this.id_pkm = id_pkm;
        this.hideInput = hideInput;
    }
    draw() {
        console.log(this.id_pkm)
        const responApi = this.response.data;
        const lengthStep = responApi.stepper.length
        if(this.withClear) this.element.empty()

        let contentStepper = ``;
        responApi.stepper.forEach(function callback(value, index) {
            contentStepper += `<button class="nav-link circle-tab ${value.isActive? `active`:``}" id="step${index+1}-tab" data-bs-toggle="pill" data-bs-target="#step${index+1}" type="button" role="tab" aria-controls="step${index+1}" aria-selected="${value.isActive? 'true':'false'}" ${value.isDisable? `disabled`:``}>${value.numberStep}</button>`
            contentStepper += index==lengthStep-1? ``:`<div class="line"></div>`       
        })
        let contentAnggota = ``;
        responApi.listAnggota.forEach(function callback(value, index) {
            contentAnggota += `<tr>
                <td>${value.nidn??"-"}</td>
                <td>${value.nama??"-"} - ${value.prodi?.namaProdi??"-"} (${value.fakultas?.namaFakultas??"-"})</td>
            </tr>`       
        })
        let contentNonAnggota = ``;
        responApi.listNonAnggota.forEach((value, index) => {
            contentNonAnggota += `<tr>
                <td>
                    ${value.npm ?? "-"}
                    ${this.id_pkm != null ? `<input type="hidden" name="anggotaNonPeneliti[${index}][npm]" value="${value.npm}">`:""}
                </td>
                <td>${value.nama ?? "-"}</td>
                <td>
                    ${this.id_pkm != null ? (this.hideInput? `${value.bukti_mbkm??""}`:`<input type="text" name="anggotaNonPeneliti[${index}][bukti_mbkm]" class="form-control" value="${value.bukti_mbkm??""}"></td>`) : ""}
                </td>
            </tr>`;
        });
        let contentNonAnggota2 = ``;
        responApi.listNonAnggota2.forEach(function callback(value, index) {
            contentNonAnggota2 += `<tr>
                <td>${value.nomorIdentitas??"-"}</td>
                <td>${value.nama??"-"}</td>
                <td>${value.afiliasi??"-"}</td>
            </tr>`
        })
        let luaranContent = ``;
        responApi.listLuaran.forEach(function callback(value, index) {
            luaranContent += `<tr>
                <td>${index+1}</td>
                <td>${value.jenisLuaran??"-"}</td>
                <td>${value.indikatorCapaian??"-"}</td>
                <td>${value.status??"-"}</td>
                <td>${value.keterangan??''}</td>
                <td>${value.link??''}</td>
            </tr>`
        })
        let rabContent = ``;
        let totalRab = 0;
        responApi.listRab.forEach(function callback(value, index) {
            const _item = value.item;
            const _harga_satuan = value.harga_satuan;
            const _total = value.harga_satuan==null || value.harga_satuan=="0" || value.harga_satuan==0? (value.total??0):((_item??0) * (_harga_satuan??0));
            totalRab += _total
            
            rabContent += `<tr>
                <td>${index+1}</td>
                <td>${value.kelompokRab??"-"}</td>
                <td>${value.komponen??"-"}</td>
                <td>${_item??"-"}</td>
                <td>${value.satuan??"-"}</td>
                <td>${_harga_satuan??"-"}</td>
                <td>${formatRupiah(`${_total}`, "Rp. ")}</td>
            </tr>`
        })
        rabContent += `<tr>
                <td class="text-end" colspan="6">Subtotal</td>
                <td>${formatRupiah(`${totalRab}`, "Rp. ")}</td>
            </tr>`

        let dokumenMitraContent = ``;
        responApi.listDokumenMitra.forEach(function callback(value, index) {
            dokumenMitraContent += `<tr>
                <td>${value.mitra??"-"}</td>
                <td>${value.provinsi??"-"}</td>
                <td>${value.kota??"-"}</td>
                <td>${value.kelompokMitra??"-"}</td>
                <td>${value.pemimpinMitra??"-"}</td>
                <td><a href="${value.fileSuratPernyataan.url}">${value.fileSuratPernyataan.fileName}</a></td>
            </tr>`
        })
        let dokumenKontrakContent = ``;
        responApi.listDokumenKontrak.forEach(function callback(value, index) {
            dokumenKontrakContent += `<tr>
                <td><a href="${value.url}">${value.file}</a></td>
                <td>${value.keterangan}</td>
            </tr>`
        })

        let content = ` <div class="nav circle-tab-container mb-3" id="pills-tab" role="tablist">
                            ${contentStepper}
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="tab-content card" id="pills-tabContent">
                                <div class="card-body tab-pane fade active show" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                                    <form action="https://sipaksi.unpak.ac.id/pkm/updateStep1" method="post">
                                        <input type="hidden" name="id_pkm" value="${this.id_pkm}">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    <h5 class="text-primary">1.1 Identitas Usulan Pengabdian</h5>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    ${viewInput("Pengusul",(responApi.dosen?.nidn??"-")+" "+(responApi.dosen?.nama??"-")+" - "+(responApi.dosen?.prodi?.namaProdi??"-")+" ("+(responApi.dosen?.fakultas?.namaFakultas??"-")+")")}
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                    ${viewInput("Tahun Pengajuan",responApi.tahunPengajuan??"-")}
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                    ${viewInput("Judul",responApi.judul??"-")}
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    <h5 class="text-primary">1.2 Pemilihan Program Pengabdian</h5>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        ${viewInput("Kategori Program Pengabdian",responApi.kategoriProgramPengabdian??"-")}
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        ${viewInput("Fokus Pengabdian",responApi.fokusPengabdian??"-")}
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        ${viewInput("RIRN",responApi.rirn??"-")}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        ${viewInput("Rumpun Ilmu 1",responApi.rumpunIlmu1??"-")}
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        ${viewInput("Rumpun Ilmu 2",responApi.rumpunIlmu2??"-")}
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        ${viewInput("Rumpun Ilmu 3",responApi.rumpunIlmu3??"-")}
                                                    </div>
                                                </div>
                                            <div class="row mt-2">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    <h5 class="text-primary">1.4 Identitas Pengusul - Anggota Peneliti</h5>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                    <table id="tbAnggotaPeneliti" class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>NIDN</th>
                                                                <th>Nama</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        ${contentAnggota}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    <h5 class="text-primary">1.5 Identitas Pengusul - Anggota Peneliti (Mahasiswa)</h5>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                    <table id="tbAnggotaPenelitiNonDosen" class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>NPM</th>
                                                                <th>Nama</th>
                                                                <th>
                                                                    Bukti MBKM<br>
                                                                    <small>(Link google drive)</small>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            ${contentNonAnggota}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    <h5 class="text-primary">1.6 Identitas Pengusul - Anggota Peneliti (Non Dosen Unpak / Non Dosen)</h5>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                    <table id="tbAnggotaPenelitiNonDosen2" class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nomor Identitas</th>
                                                                <th>Nama</th>
                                                                <th>Afiliasi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            ${contentNonAnggota2}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="d-flex justify-content-between gap-2">
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2"></div>
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                                                ${this.id_pkm!=null? `<button type="submit" class="btn btn-success">Update</button>`:``}
                                                <button type="button" class="btn btn-primary" id="nextStep1">Lanjut</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                <h5 class="text-primary">2.1 Substansi Usulan</h5>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                <label class="form-label">Unggah Substansi Laporan</label><br>
                                                <a href="${responApi.substansiLuaran?.url??"#"}">${responApi.substansiLuaran?.fileName??"-"}</a>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                <h5 class="text-primary">2.2 Luaran</h5>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                <table id="tbLuaranMitra" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td>#</td>
                                                            <td>Jenis Luaran</td>
                                                            <td>Indikator Capaian</td>
                                                            <td>Status</td>
                                                            <td>Keterangan</td>
                                                            <td>Link</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="contentLuaranMitra">
                                                        ${luaranContent}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between gap-2">
                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                                            <button type="button" class="btn btn-secondary mr-2" id="prevStep2">Previous</button>
                                            <button type="button" class="btn btn-primary" id="nextStep2">Lanjut</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body tab-pane fade" id="step3" role="tabpanel" aria-labelledby="step3-tab">
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                <h5 class="text-primary">3.1 Rencana Anggaran Biaya</h5>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                <table id="tbRab" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td>#</td>
                                                            <td>Kelompok RAB</td>
                                                            <td>Komponen</td>
                                                            <td>Item</td>
                                                            <td>Satuan</td>
                                                            <td>Harga Satuan</td>
                                                            <td>Total</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="contentRab">
                                                        ${rabContent}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between gap-2">
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2"></div>
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                                                <button type="button" class="btn btn-secondary mr-2" id="prevStep3">Previous</button>
                                                <button type="button" class="btn btn-primary" id="nextStep3">Lanjut</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body tab-pane fade" id="step4" role="tabpanel" aria-labelledby="step4-tab">
                                        <div class="row">
                                            <div class="row mt-2">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    <h5 class="text-primary">4.1 Mitra</h5>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                    <table id="tbMitra" class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Mitra</th>
                                                                <th>Provinsi</th>
                                                                <th>Kota</th>
                                                                <th>Kelompok Mitra</th>
                                                                <th>Pemimpin Mitra</th>
                                                                <th>Surat Pernyataan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            ${dokumenMitraContent}
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                    <h5 class="text-primary">4.2 Dokumen Lainnya (Kontrak/Orisinalitas/Lainnya)</h5>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 table-responsive">
                                                    <table id="tbKontrak" class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>File</th>
                                                                <th>Keterangan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            ${dokumenKontrakContent}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between gap-2">
                                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2"></div>
                                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                                                    <button type="button" class="btn btn-secondary mr-2" id="prevStep4">Previous</button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>`;

        this.element.append(content)

        const step1Tab = document.getElementById("step1-tab");
        const step2Tab = document.getElementById("step2-tab");
        const step3Tab = document.getElementById("step3-tab");
        const step4Tab = document.getElementById("step4-tab");

        $('#nextStep1').click(function(e) {
            e.preventDefault();
            step2Tab.removeAttribute("disabled");
            step2Tab.click();
        });
        $('#nextStep2').click(function(e) {
            e.preventDefault();
            step3Tab.removeAttribute("disabled");
            step3Tab.click();
        });
        $('#nextStep3').click(function(e) {
            e.preventDefault();
            step4Tab.removeAttribute("disabled");
            step4Tab.click();
        });

        $('#prevStep2').click(function(e){
            e.preventDefault();
            step1Tab.click();
        });
        $('#prevStep3').click(function(e) {
            e.preventDefault();
            step2Tab.click();
        });
        $('#prevStep4').click(function(e) {
            e.preventDefault();
            step3Tab.click();
        });
    }
}