<template>
    <div class="container">
    <div class="row justify-content-center">
    <div class="container-fluid col-md-8">

 <!--
█▀ █▀▀ ▄▀█ █▀█ █▀▀ █░█
▄█ ██▄ █▀█ █▀▄ █▄▄ █▀█
 -->
 <!-- = = = = = = = =  =  =  = = [COMPONENT][Card:Search] -->


<card-cp title="Search for models">
    <template v-slot:content>
  
<p v-if="opsearch==false">
  <a class="btn btn-primary" @click="openSearch()">
    Open Search
  </a>
</p>
<p v-if="opsearch==true">
<button class="btn btn-danger"  @click="openSearch()">
      Close Search  
     </button>
</p>
<div id="collSearch" v-if="opsearch==true">

       <input type="number"  class="form-control mb-2" id="inputid" aria-describedby="idHelp" placeholder="ID" ref="inputid">
     <input type="text" class="form-control mb-2" id="inputname" aria-describedby="nameHelp"
        placeholder="name of model"  ref="inputname">
     <input type="number" class="form-control mb-2" id="inputdoors" aria-describedby="nameHelp"
        placeholder="amount of doors"  ref="inputdoors">

        <input type="number" class="form-control mb-2" id="inputseats" aria-describedby="nameHelp"
        placeholder="amount of seats"  ref="inputseats">
        <input type="number" class="form-control mb-2" id="inputairbags" aria-describedby="nameHelp"
        placeholder="1 if have air bag - 0 if don't have air bag"  ref="inputairbags">
        <input type="number" class="form-control mb-2" id="inputabs" aria-describedby="nameHelp"
        placeholder="1 if have abs - 0 if don't have abs"  ref="inputabs">

     <p><button class="btn btn-primary btn-sm mb-3" @click="searchh()">Search</button></p>

</div>
    
 
   
    </template>
    </card-cp>
     



 <!-- = = = = = = = =  =  [End of Card:Search] = -->
<!--
▄▀█ █▀▄ █▀▄
█▀█ █▄▀ █▄▀
-->
<!-- = = = = = = = =  =  =[COMPONENT][Modal:Add]-->
<dmodal-cp modalname="modalAdd" title="Add Model">
<template slot="alerts"> 

 <alert-cp stll="success" title="Transaction performed with success" :details="$store.state.transact" v-if="$store.state.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="error in Transaction" 
    :details="$store.state.transact" v-if="$store.state.transact.status == 'error'">
    </alert-cp>

     
</template>

    <template slot="content"> 
    <div class="container-sm">
    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="newNameHelp">Name</span>
    <input type="text" class="form-control" id="newName" placeholder="name of model" 
    aria-describedby="newNameHelp" v-model="namemodel"></div>

    
 
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariadoors">Doors</span>
    <input type="number" class="form-control" id="doorsmodel" placeholder="amount" 
    aria-describedby="ariadoors" v-model="doorsmodel"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaseats">Seats</span>
    <input type="number" class="form-control" id="seatsmodel" placeholder="amount" 
    aria-describedby="ariaseats" v-model="seatsmodel"></div>
   
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariabags">Air Bags</span>
    <input type="number" class="form-control" id="airbagmodel" placeholder="amount" 
    aria-describedby="ariabags" v-model="airbagmodel"></div>

    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaabs">ABS</span>
    <input type="number" class="form-control" id="absmodel" placeholder="amount" 
    aria-describedby="ariaabs" v-model="absmodel"></div>

    <div class="input-group input-group-sm mb-3">
     <span class="input-group-text" id="ariaabs">Brand</span>
    <select v-model="refname" class="form-select form-select-sm">
        <option v-for="itt in refbrandsCP" :value="itt[0]">{{itt[1]}}</option>
    </select>
    </div>

    <div class="form-group"> <!-- = =[Input:Image] = = -->
     
    <input-cp title="Image" id="newImage" id-help="newImageHelp"
    text-help="Select the image in format PNG">
    <input type="file" class="form-control-file" id="newImage" aria-describedby="newImageHelp" placeholder="Select a Image"
    @change="loadImage($event)">
    </input-cp> 
    </div>
    

    </div>
    </template>

      <template slot="footer">
        <button type="button" class="btn btn-primary"
        @click="saveh()">save</button>
        </template>
</dmodal-cp>

    <!-- = = = = = = = =  =  [End of Modal] -->

<!--
█░█ █ █▀▀ █░█░█
▀▄▀ █ ██▄ ▀▄▀▄▀
-->
<dmodal-cp modalname="modalView" title="View Model">
       <template slot="alerts"></template>
       <template slot="content"> 
    
   <h4>{{$store.state.item.Name}}</h4> <hr>

    

    <div class="container">
  <div class="row">
    <div class="col">Brand: {{$store.state.item.Brand}}</div>
    <div class="col">ID: {{$store.state.item.ID}}</div>
    <div class="col">
    </div>
  </div>

  <div class="row">
    <div class="col">
    <img :src="'/'+$store.state.item.Image" width="273" height="192">
    </div>
    <div class="col"></div>
    <div class="col"></div>
  </div>

  <div class="row">
    <div class="col">Doors: {{$store.state.item.Doors}}</div>
    <div class="col">Air Bag: {{$store.state.item['Air Bag']}}</div>
    <div class="col">Seats: {{$store.state.item.Seats}}</div>
  </div>

   <div class="row">
    <div class="col">ABS: {{$store.state.item.ABS}}</div>
    <div class="col"></div>
    <div class="col"></div>
  </div>

</div>
       
       <br>
       </template>
       <template slot="footer">
       </template>

   </dmodal-cp>
<!--
█░█ █▀█ █▀▄
█▄█ █▀▀ █▄▀
-->
 <dmodal-cp modalname="modalUpd" title="Update Model">
  <template slot="alerts">
    <alert-cp stll="success" title="Transaction performed with success" :details="$store.state.transact" v-if="$store.state.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="error in Transaction" 
    :details="$store.state.transact" v-if="$store.state.transact.status == 'error'">
    </alert-cp>
  </template>

    <template slot="content"> 
       {{setUpdValues()}} 
    <div class="container-sm">
    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="newNameHelp">Name</span>
    <input type="text" class="form-control" id="newName" placeholder="name of model" 
    aria-describedby="newNameHelp" v-model="$store.state.item.Name"></div>

    
 
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariadoors">Doors</span>
    <input type="number" class="form-control" id="doorsmodel" placeholder="amount" 
    aria-describedby="ariadoors" v-model="$store.state.item.Doors"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaseats">Seats</span>
    <input type="number" class="form-control" id="seatsmodel" placeholder="amount" 
    aria-describedby="ariaseats" v-model="$store.state.item.Seats"></div>
   
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariabags">Air Bags</span>
    <input type="number" class="form-control" id="airbagmodel" placeholder="amount" 
    aria-describedby="ariabags" v-model="$store.state.item['Air Bag']"></div>

    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaabs">ABS</span>
    <input type="number" class="form-control" id="absmodel" placeholder="amount" 
    aria-describedby="ariaabs" v-model="$store.state.item.ABS"></div>

    <div class="input-group input-group-sm mb-3">
     <span class="input-group-text" id="ariaabs">Brand</span>
    <select ref="refUpdBrand" class="form-select form-select-sm">
        <option :value="$store.state.item.Brand_ID" selected>{{$store.state.item.Brand}}</option>
        <option v-for="itt in refbrandsCP" :value="itt[0]">{{itt[1]}}</option>
    </select>
    </div>

    <div class="form-group"> <!-- = =[Input:Image] = = -->
     
    <input-cp title="Image" id="newImage" id-help="newImageHelp"
    text-help="Select the image in format PNG">
    <input type="file" class="form-control-file" id="newImage" aria-describedby="newImageHelp" placeholder="Select a Image"
    @change="loadImage($event)">
    </input-cp> 
    </div>
        </div>
       </template>

       <template slot="footer">
       <button type="button" class="btn btn-secondary" @click="resetValues()">Clear</button>
        <button type="button" class="btn btn-primary" @click="updateh()">Update</button>
       </template>

   </dmodal-cp>
<!--
█▀▄ █▀▀ █░░
█▄▀ ██▄ █▄▄
-->
<dmodal-cp modalname="modalDel" title="View brand">
       <template slot="alerts">
           <alert-cp stll="success" title="Deleted  with success" :details="$store.state.transact" v-if="$store.state.transact.status == 'success'"></alert-cp>
            <alert-cp stll="danger" title="error to delete proccess" :details="$store.state.transact" v-if="$store.state.transact.status == 'error'"></alert-cp>
       </template>
       <template slot="content"> 
       <h4>Delete the Model with follow content</h4><hr>
       <li> ID: {{$store.state.item.ID}}</li>
       <li> Name: {{$store.state.item.Name}}</li>
       <li> Image: <img :src="'/'+$store.state.item.Image" width="150" height="87"></li>
       <br>
       </template>
       <template slot="footer">
         <button type="button" class="btn btn-danger" @click="deleteh()" v-if="$store.state.transact.status != 'success'">Confirm</button>
       </template>

   </dmodal-cp>










<!--
█░░ █ █▀ ▀█▀
█▄▄ █ ▄█ ░█░
-->
<!-- = = = = = = = =  =  =[COMPONENT][Card:List]  -->
<card-cp title="List of models">

    <template slot="content">
     <table-cp :dbdatas="modelsdata"
               :titles="titlesCP"
               :dview="{visible:true, dataTarget:'modalView'}"
               :ddel="{visible:true, dataTarget:'modalDel'}"
               :dupd="{visible:true, dataTarget:'modalUpd'}"
               :config="{title:'Operations', amountcolls: 1, refrow:'ref_car_brand',refname:'name', visible:true, typer:'last', imagefield:'Image'}"
              
     ></table-cp>
      </template>

      <template slot="footer">
      <button type="button" class="btn btn-primary btn-sm float-right"
      onclick="document.getElementById('modalAdd').style.display='block'">Add</button>
<!--button type="button" class="btn btn-primary btn-sm float-right"
      @click="printVall()">VVV</button -->
     

    </template>

    </card-cp>
<!-- = = = = = = = =  =  = [End of Card:List] = -->


</div>
</div>
</div>
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
</template>
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->




<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
<!-- = = = = = = = =  = 
█░█ █░█ █▀▀
▀▄▀ █▄█ ██▄
 =  =  =  =  =  =  -->
<script>
/*
id, brand_id, name, image, doors, seats. air_bag, abs, created_at, updated_at
*/
    export default {
        computed: {
/* . . . . . . . . . . . . . . . . . . . */            
            token() {

                 let token = document.cookie.split(';').find(ind => {
                    return ind.includes('token=')
                })

                token = token.split('=')[1]
                token = 'Bearer ' + token

                return token
            },
/* . . . . . . . . . . . . . . . . . . . */        
      titlesCP(){
       let atitles={ id:{title:'ID', ordershow:1, visible:true},
       name:{title:'Name', ordershow:2,visible:true},
       image:{title:'Image', ordershow:3,visible:true},
       doors:{title:'Doors', ordershow:4, visible:true},
       seats:{title:'Seats', ordershow:5, visible:false},
       air_bag:{title:'Air Bag', ordershow:6, visible:false},
       abs:{title:'ABS', ordershow:7, visible:false},
       ref_car_brand:{title:'Brand', ordershow:8,visible:true},
       brand_id:{title:'Brand_ID', ordershow:9, visible:false}
       
               }; 
                return atitles;
        },
/* . . . . . . . . . . . . . . . . . . . */      
    refbrandsCP(){
        let neovar=[];
        Object.entries(this.refBrandVals).forEach(jobj => {
            let tmpv=[];
            const pn = Object.keys(jobj);
            tmpv[0]=jobj['1'].id;
            tmpv[1]=jobj['1'].brand;
            neovar.push(tmpv);
        });
        return neovar;
    }
 /* . . . . . . . . . . . . . . . . . . . */           
        },
 /* . . . . . . . . . . . . . . . . . . . */         
        data() {
            return {
                urlBase: '/api/v1/model',
                namemodel:'',
                doorsmodel:0,
                seatsmodel:0,
                airbagmodel:0,
                absmodel:0,
                fileImage: [],
                amountReq: 0,
                refBrandVals: {},
                modelsdata:[],
                refname:0,
                fileInputKey: 0,
                evtarget:'',
                selected:'id',
                opsearch:false,
                
               // datasearch:[],
              //  insearch:'false'
                
            }
        },
 /* . . . . . . . . . . . . . . . . . . . */
        methods: {
 /* . . . . . . . . . . . . . . . . . . . */
openSearch(){
    if (this.opsearch==true){
        this.opsearch=false;
        this.loadList();
    } else{
        this.opsearch=true
        
    }
},
 /* . . . . . . . . . . . . . . . . . . . */
printVall(){
///* 
    let vol={};
    vol=this.refBrandVals;
    Object.entries(vol).forEach(jobj => {
        //console.log(jobj.id+" "+jobj.name);
        console.log(jobj);
        });
        console.log(this.$refs.refUpdBrand.value);
 //*/
   // let vil=this.refbrandsCP;
    //vil.forEach((ell)=>{ console.log(ell); })       
},
 /* . . . . . . . . . . . . . . . . . . . */
 setUpdValues(){
    //<option :value="$store.state.item"></option>
    this.fileInputKey=this.$store.state.item.ID;
    
 },
   /* . . . . . . . . . . . . . . . . . . . */
     setRefBrands(){

    //if ( this.amountReq==2 ){
    let uriI=this.urlBase+"?refbrandvalues=true"; //refbrandvalues
    //console.log("11111111 "+uriI);
    let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      axios.get(uriI, config)
          .then(response => {
             this.refBrandVals = response.data;
             this.amountReq++;
          })
          .catch(errors => {
              console.log(errors)
          });

  
   // }    
   },  

 /* . . . . . . . . . . . . . . . . . . . */
  resetValues(){
  // this.$refs.updName.value='';
   this.evtarget.value='';
    //this.fileInputKey=-1;
    console.log(this.fileImage[0]);
    //if (this.$refs.updName!=undefined){
      console.log(this.$store.state.item.name);
   //}
   //this.$refs.updName.value='';
  },

 /* . . . . . . . . . . . . . . . . . . . */
searchh(){
    this.$store.state.transact.status='';
    this.$store.state.transact.message='';
    let vallSearch='';
    let urii="";
//inputid inputname inputdoors inputseats inputairbags inputabs
//let valss=window.btoa(this.selected+'&&&'+this.inpSearchId)
    if (this.$refs.inputid.value!=''){
        vallSearch="id="+this.$refs.inputid.value;
    }
    if (this.$refs.inputname.value!=''){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="name="+this.$refs.inputname.value;
    }
      if (this.$refs.inputdoors.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="doors="+this.$refs.inputdoors.value;
    }
      if (this.$refs.inputseats.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch="seats="+this.$refs.inputseats.value;
    }
      if (this.$refs.inputairbags.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="air_bag="+this.$refs.inputairbags.value;
    }
      if (this.$refs.inputabs.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="abs="+this.$refs.inputabs.value;
    }
    // - - - - - - - - - - - - - - - - - -
    vallSearch=window.btoa(vallSearch);
    vallSearch="?filter="+vallSearch;
    urii=this.urlBase+vallSearch;
   let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      console.log(vallSearch);
      axios.get(urii, config)
          .then(response => {
              this.modelsdata = response.data;
             // this.datasearch = response.data;
              //this.insearch='true';
              //console.log(this.datasearch);
          })
          .catch(errors => {
            alert("the resource was not found");
              console.log(" - - - -");
              console.log(errors.response.data.message);
          })


},
/* . . . . . . . . . . . . . . . . . . . */


 /* . . . . . . . . . . . . . . . . . . . */
  updateh() {
    this.$store.state.transact.status='';
    this.$store.state.transact.message='';
   // this.namemodel=this.$store.state.item.Name; 
    this.refname=this.$refs.refUpdBrand.value;
    let formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('name', this.$store.state.item.Name);
    formData.append('brand_id',this.refname);
    formData.append('doors',this.$store.state.item.Doors);
    formData.append('seats',this.$store.state.item.Seats);
    formData.append('air_bag',this.$store.state.item['Air Bag']);
    formData.append('abs',this.$store.state.item.ABS);
    //formData.append('',this.$store.state.item.);
 
    if(this.fileImage[0]) {
        formData.append('image', this.fileImage[0]);
        this.resetValues();
    }

    let url = this.urlBase + '/' + this.$store.state.item.ID

    let config = {
        headers: {
            'Content-Type': 'multipart/form-data',
            'Accept': 'application/json',
            'Authorization': this.token
        }
    }

    axios.post(url, formData, config)
    .then(response => {
        this.$store.state.transact.status = 'success';
        this.$store.state.transact.message = 'The register was updated';
          console.log("Enter response");
       //
        this.loadList();
          // this.$store.state.item.name=this.namemodel;
            //this.fileInputKey=0;
    })
    .catch(errors => {
        
         this.$store.state.transact.status = 'error';
         this.$store.state.transact.message = errors.response.data.message;
       
        console.log("Enter errors");
      
        
    })
},
 /* . . . . . . . . . . . . . . . . . . . */
  deleteh() {
    this.$store.state.transact.status='';
    this.$store.state.transact.message='';
     let formData = new FormData();
     formData.append('_method', 'DELETE')

        let config = {
        headers: {
            'Accept': 'application/json',
            'Authorization': this.token
        }
    }
     let url = this.urlBase + '/' + this.$store.state.item.ID

     axios.post(url, formData,config)
         .then(response => {
             this.$store.state.transact.status = 'success';
             this.$store.state.transact.message = response.data.message;
             this.loadList(); 
         })
         .catch(errors => {
             this.$store.state.transact.status = 'error';
             this.$store.state.transact.message = errors.response.data.message;
         })
        

  },
 /* . . . . . . . . . . . . . . . . . . . */
  loadList() {
    
      let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      //console.log("List Loaded");
      axios.get(this.urlBase, config)
          .then(response => {
              this.modelsdata = response.data
              //console.log(this.brands)
          })
          .catch(errors => {
              console.log(errors)
          })
 },
/* . . . . . . . . . . . . . . . . . . . */
            loadImage(e) {
                // e.target.value='';
                this.evtarget=e.target;
                this.fileImage = e.target.files;
               
               //console.log(e.target.files);
            },
/* . . . . . . . . . . . . . . . . . . . */

/* . . . . . . . . . . . . . . . . . . . */
    saveh() {
        console.log(this.namemodel, this.fileImage[0])
/* namemodel  doorsmodel seatsmodel 
airbagmodel absmodel refname this.fileImage[0] */
        let formData = new FormData();
        formData.append('name', this.namemodel);
        formData.append('doors', this.doorsmodel);
        formData.append('seats', this.seatsmodel);
        formData.append('air_bag', this.airbagmodel);
        formData.append('abs', this.absmodel);
        formData.append('brand_id', this.refname);
        formData.append('image', this.fileImage[0]);

        let config = {
            headers: {                    
           'Content-Type': 'multipart/form-data',
           'Accept': 'application/json',
           'Authorization': this.token
           }
        }

        axios.post(this.urlBase, formData, config)
         .then(response => {
             this.$store.state.transact.status = 'success';
             this.$store.state.transact.message = 'Register ID: '+response.data.id; 
             //console.log("\n[add]The response Value: "+JSON.stringify(response))
              this.loadList()
        })
       .catch(errors => {
         this.$store.state.transact.status = 'error';
             this.$store.state.transact.message = errors.response.data.message; 

        })

    }
/* . . . . . . . . . . . . . . . . . . . */
        },
/* . . . . . . . . . . . . . . . . . . . */
        mounted() {  
            this.loadList();
           this.setRefBrands();
            

        }
    }
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */


</script>

