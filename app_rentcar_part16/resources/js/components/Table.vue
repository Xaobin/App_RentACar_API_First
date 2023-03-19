<template>
    <div>
    <table class="table table-hover">
        <thead>
        <tr>
        <th scope="col" v-for="t, key in titles" :key="key">{{t.title}}</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="obj, keyx in filterDatasII" :key="keyx">
            <td v-for="value, keyValue in obj" :key="keyValue">
 <span v-for="vv, kv in titlefieldsII" :key="kv">
<span v-if="((titles[vv].title==keyValue)&&(titles[vv].typer=='id')&&(titles[vv].visible==true))">{{value}}
</span>
<span v-if="((titles[vv].title==keyValue)&&(titles[vv].typer=='image')&&(titles[vv].visible==true))">{{value}}
</span>
<span v-if="((titles[vv].title==keyValue)&&(titles[vv].typer=='text')&&(titles[vv].visible==true))">{{value}}
</span>

</span>



            </td>
            
            </tr>
        </tbody>
    </table>








</div>
</template>

<script>
//import store from 'vuex';

export default {
        props: ['dbdatas', 'titles','config', 'dview','dupd','ddel'],
          data() {
            return {
                openmodal:'false',
                mousein:'true',
                jobj:{}
            }
        },
        methods:{
            setStore(obj){
                this.$store.state.item=obj;
               let mdname=this.dview.dataTarget; 
                document.getElementById(mdname).style.display='block';
            },
         setStoreUpd(obj){
                this.$store.state.item=obj;
               let mdname=this.dupd.dataTarget; 
                document.getElementById(mdname).style.display='block';
            },
        setStoreDel(obj){
                this.$store.state.item=obj;
               let mdname=this.ddel.dataTarget; 
                document.getElementById(mdname).style.display='block';
            },
            
    },

        computed: {
            titlefieldsII(){
                let titlefieldx = Object.keys(this.titles);
                return titlefieldx;
            },
// = =  = =  = =  = =  = =  = =  = =  = =  = =  = =  = =              
// = =  = =  = =  = =  = =  = =  = =  = =  = =  = =  = = 
        filterDatasII(){
         let neovar=[];
         let elem={};
         var nid=0;
         let titlefields = Object.keys(this.titles);

        this.dbdatas.forEach(jobj => {
        Object.entries(jobj).forEach(([khey, vall]) => {
         
            const inkey = titlefields.includes(khey);
            if (inkey==true){
            titlefields.forEach((kk,ii)=>{ 
             
             
                let ttt=this.titles[kk].title;
                if ((khey==kk)&&(ii==0)){
                    nid=vall; elem[ttt]=vall;
                }    
                if ((khey==kk)&&(ii>0)&&(khey!=this.config.refrow)){
                    elem[ttt]=vall;
                }
                if ((khey==kk)&&(ii>0)&&(khey==this.config.refrow)){    
                    elem[ttt]=vall.name;
                }
                                
            });          
          }
        
        });
        ///*
        let tmp=nid;
        let lele=this.config.amountcolls;
        for (var i = 1; i <= lele; i++) {
            elem['nid']=nid;    
            if (i>1){ elem['nid'+i]=nid; }
        }    
        //console.log(elem);
         neovar.push(elem);
                elem={};
                nid=0;
           
    });
   // neovar.forEach((ell)=>{ console.log(ell); })
            return neovar;  

             }
// - - - - - - - - - - - - - - - - - -                     
        },
// - - - - - - - - - - - - - - - - - -        
mounted() {
   
},        
// - - - - - - - - - - - - - - - - - -        
}
// - - - - - - - - - - - - - - - - - -     
/*
Object.keys(obj) = [ "ID", "Name", "Image", "Doors", "Brand", "nid" ] 
Object.keys(titles)=[ "id", "name", "image", "doors", "ref_car_brand", "config" ] 
titles.title = [ "ID", "Name", "Image", "Doors", "Brand", "Operations"

titlefieldsII = id - 0 name - 1 image - 2 doors - 3 ref_car_brand - 4 config - 5 
*/
</script>


