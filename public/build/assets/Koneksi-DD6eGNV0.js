import{_ as h}from"./AuthenticatedLayout-Dx3NYzWI.js";import{o as l,f as s,a as e,u as a,w as t,F as r,Z as p,b as d,d as u,l as i,t as n,c as g}from"./app-Bw3cCDBp.js";import{a as x,b as y,p as b,f as _,u as k,g as w,c as m}from"./flowbite-vue-6AI5Yh9O.js";import"./ApplicationLogo-Md45CMIO.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const N=d("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Dashboard",-1),v={class:"py-12"},B={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},T={class:"w-full text-sm text-left text-gray-500 dark:text-gray-400"},F={class:"w-full text-sm text-left text-gray-500 dark:text-gray-400"},D={key:1,class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},K={class:"p-6 text-gray-900"},S={__name:"Koneksi",props:{id:Number,data:Object},setup(o){return(V,E)=>(l(),s(r,null,[e(a(p),{title:"Dashboard"}),e(h,null,{header:t(()=>[N]),default:t(()=>[d("div",v,[d("div",B,[o.data.success?(l(),s(r,{key:0},[e(a(x),{type:"success"},{default:t(()=>[u(" Koneksi Berhasil. ")]),_:1}),e(a(y),null,{default:t(()=>[e(a(b),null,{default:t(()=>[e(a(_),null,{default:t(()=>[u("Nama Table")]),_:1}),e(a(_),null,{default:t(()=>[u("Nama Field")]),_:1}),e(a(_),null,{default:t(()=>[u("Type Field")]),_:1})]),_:1}),e(a(k),null,{default:t(()=>[(l(!0),s(r,null,i(o.data.listTables,f=>(l(),g(a(w),null,{default:t(()=>[e(a(m),null,{default:t(()=>[u(n(f.table),1)]),_:2},1024),e(a(m),null,{default:t(()=>[d("table",T,[(l(!0),s(r,null,i(f.fieldName,c=>(l(),s("tr",null,[d("td",null,n(c),1)]))),256))])]),_:2},1024),e(a(m),null,{default:t(()=>[d("table",F,[(l(!0),s(r,null,i(f.fieldType,c=>(l(),s("tr",null,[d("td",null,n(c),1)]))),256))])]),_:2},1024)]),_:2},1024))),256))]),_:1})]),_:1})],64)):(l(),s("div",D,[d("div",K,[e(a(x),{type:"danger"},{default:t(()=>[u(" Koneksi Error! "+n(o.data.message)+". ",1)]),_:1})])]))])])]),_:1})],64))}};export{S as default};
