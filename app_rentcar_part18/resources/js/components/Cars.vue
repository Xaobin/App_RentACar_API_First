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

  <input type="text" class="form-control mb-2" id="inputplate" aria-describedby="Plate"
        placeholder="Plate"  ref="inputplate">

     <input type="text" class="form-control mb-2" id="inputavail" aria-describedby="Available"
        placeholder="Available"  ref="inputavail">

     <input type="number" class="form-control mb-2" id="inputkm" aria-describedby="kilometers"
        placeholder="kms"  ref="inputkm">

   

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
<dmodal-cp modalname="modalAdd" title="Add Car">
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
     <span class="input-group-text" id="newplateHelp">Plate</span>
    <input type="text" class="form-control" id="newPlate" placeholder="plate's name" 
    aria-describedby="newPlateHelp" v-model="platecar"></div>

    
 
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariadoors">Available</span>
    <input type="number" class="form-control" id="avail_car" 
    placeholder="Is available?" 
    aria-describedby="avail_car" v-model="availcar"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaseats">Km</span>
    <input type="number" class="form-control" id="km_car" placeholder="Kilometers" 
    aria-describedby="km_car" v-model="kmcar"></div>
   

    <div class="input-group input-group-sm mb-3">
     <span class="input-group-text" id="ariaabs">Model</span>
    <select ref="refnnmm" class="form-select form-select-sm">
        <option v-for="itt in refmodelsCP" :value="itt[0]">{{itt[1]}}</option>
    </select>
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
<dmodal-cp modalname="modalView" title="View Car">
       <template slot="alerts"></template>
       <template slot="content"> 
    
   <h4>{{$store.state.item.Plate}}</h4> <hr>

    
<div class="container">
  
    <li class="col">Plate: {{$store.state.item.Plate}}</li>
    <li class="col">ID: {{$store.state.item.ID}}</li>
    <li class="col">Available: {{$store.state.item.Available}}</li>
    <li class="col">Kilometers: {{$store.state.item.KM}}</li>
    <li class="col">Created: {{$store.state.item.Created}}</li>
    <li class="col">Updated: {{$store.state.item.Updated}}</li>
  

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
 <dmodal-cp modalname="modalUpd" title="Update Car">
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
     <span class="input-group-text" id="newNameHelp">Plate</span>
    <input type="text" class="form-control" id="newName" placeholder="plate" 
    aria-describedby="Plate" v-model="$store.state.item.Plate"></div>

    
 
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariadoors">Available</span>
    <input type="number" class="form-control" id="avail_car" placeholder="amount" 
    aria-describedby="Available" v-model="$store.state.item.Available"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaseats">Kilometers</span>
    <input type="number" class="form-control" id="km_car" placeholder="amount" 
    aria-describedby="Kilometers" v-model="$store.state.item.KM"></div>

    <div class="input-group input-group-sm mb-3">
     <span class="input-group-text" id="ariaabs">Model</span>
    <select ref="refUpdModel" class="form-select form-select-sm">
        <option :value="$store.state.item.Model_ID" selected>{{$store.state.item.Model}}</option>
        <option v-for="itt in refmodelsCP" :value="itt[0]">{{itt[1]}}</option>
    </select>
    </div>

    
        </div>
       </template>

       <template slot="footer">
        <button type="button" class="btn btn-primary" @click="updateh()">Update</button>
       </template>

   </dmodal-cp>
<!--
█▀▄ █▀▀ █░░
█▄▀ ██▄ █▄▄
-->
<dmodal-cp modalname="modalDel" title="View car">
       <template slot="alerts">
           <alert-cp stll="success" title="Deleted  with success" :details="$store.state.transact" v-if="$store.state.transact.status == 'success'"></alert-cp>
            <alert-cp stll="danger" title="error to delete proccess" :details="$store.state.transact" v-if="$store.state.transact.status == 'error'"></alert-cp>
       </template>
       <template slot="content"> 
       <h4>Delete the car with follow content</h4><hr>
       <li> ID: {{$store.state.item.ID}}</li>
       <li> Plate: {{$store.state.item.Plate}}</li>
       <li> KM: {{$store.state.item.KM}}</li>
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
     <table-cp :dbdatas="carsdata"
               :titles="titlesCP"
               :dview="{visible:true, dataTarget:'modalView'}"
               :ddel="{visible:true, dataTarget:'modalDel'}"
               :dupd="{visible:true, dataTarget:'modalUpd'}"
               :config="{title:'Operations', amountcolls: 1, refrow:'car_model',refname:'name', visible:true, typer:'last', imagefield:'Nullable'}"
              
     ></table-cp>
      </template>

      <template slot="footer">
      <button type="button" class="btn btn-primary btn-sm float-right"
      onclick="document.getElementById('modalAdd').style.display='block'">Add</button>

     

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
id 	model_id 	plate 	available 	km 	created_at 	updated_at
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
    plate:{title:'Plate', ordershow:2,visible:true},
    available:{title:'Available', ordershow:3, visible:true},
    km:{title:'KM', ordershow:4, visible:false},
    updated_at:{title:'Updated', ordershow:5, visible:false},
    created_at:{title:'Created', ordershow:6, visible:false},
    car_model:{title:'Model', ordershow:7,visible:true},
    model_id:{title:'Model_ID', ordershow:8, visible:false}
    
            }; 
             return atitles;
     },
/* . . . . . . . . . . . . . . . . . . . */      
    refmodelsCP(){
        let neovar=[];
        Object.entries(this.refModelVals).forEach(jobj => {
            let tmpv=[];
            const pn = Object.keys(jobj);
            tmpv[0]=jobj['1'].id;
            tmpv[1]=jobj['1'].model; // !!!!!!!
            neovar.push(tmpv);
        });
      
        return neovar;
    }
 /* . . . . . . . . . . . . . . . . . . . */           
        },
 /* . . . . . . . . . . . . . . . . . . . */         
        data() {
            return {
                urlBase: '/api/v1/car',
                platecar:'',
                availcar:0,
                kmcar:0,
                refname:'',

                //amountReq: 0,
                refModelVals: {},
                carsdata:[],
               
               // fileInputKey: 0,
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
    vol=this.refModelVals;
    Object.entries(vol).forEach(jobj => {
        //console.log(jobj.id+" "+jobj.name);
        console.log(jobj);
        });
       // console.log(this.$refs.refUpdModel.value);
 //*/
   // let vil=this.refmodelsCP;
    //vil.forEach((ell)=>{ console.log(ell); })       
},
 /* . . . . . . . . . . . . . . . . . . . */
 setUpdValues(){
    //<option :value="$store.state.item"></option>
    //this.fileInputKey=this.$store.state.item.ID;
    
 },
   /* . . . . . . . . . . . . . . . . . . . */
     setRefModels(){

    //if ( this.amountReq==2 ){
    let uriI=this.urlBase+"?refmodelvalues=true"; 
    //console.log("11111111 "+uriI);
    let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      axios.get(uriI, config)
          .then(response => {
             this.refModelVals = response.data;
            // this.amountReq++;
          })
          .catch(errors => {
              console.log(errors)
          });

  this.printVall();
   // }    
   },  

 /* . . . . . . . . . . . . . . . . . . . */
  resetValues(){
  // .$refs.updName.value='';
   //.evtarget.value='';
    //.fileInputKey=-1;
   // console.log( .fileImage [0]);
    // (.$refs.updName!=undefined){
    //  console.log(.$store.state.item.name);
   //}
   //.$refs.updName.value='';
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
    if (this.$refs.inputplate.value!=''){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="plate="+this.$refs.inputplate.value;
    }

    if (this.$refs.inputavail.value!=''){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="available="+this.$refs.inputavail.value;
    }
      if (this.$refs.inputkm.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="km="+this.$refs.inputkm.value;
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
              this.carsdata = response.data;
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
   // this.refname=this.$refs.refUpdModel.value;
    let formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('plate', this.$store.state.item.Plate);
    formData.append('model_id',this.$refs.refUpdModel.value);
    formData.append('available',this.$store.state.item.Available);
    formData.append('km',this.$store.state.item.KM);
   
    
 /*
    // this. fileImage [0] ) {
    / //   formData .append('image', this . fileImage[0] );
    ///    this.resetValues();
  ///  }
*/
    let url = this.urlBase + '/' + this.$store.state.item.ID

    let config = {
        headers: {
           /// 'Content-Type': 'multipart/form-data',
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
              this.carsdata = response.data
              //console.log(this.brands)
          })
          .catch(errors => {
              console.log(errors)
          })
 },
/* . . . . . . . . . . . . . . . . . . . */
            //loadImage(e) {
                // e.target.value='';
                //this.evtarget=e.target;
                //this.fileImage = e.target.files;
               
               //console.log(e.target.files);
            //},
/* . . . . . . . . . . . . . . . . . . . */

/* . . . . . . . . . . . . . . . . . . . */
    saveh() {
        
        let formData = new FormData();
        formData.append('plate', this.platecar);
        formData.append('available', this.availcar);
        formData.append('km', this.kmcar);
       
        formData.append('model_id', this.$refs.refnnmm.value);
        

        let config = {
            headers: {                    
           //'Content-Type': 'multipart/form-data',
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
           this.setRefModels();
            

        }
    }
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */


</script>

