import { forIn } from "lodash";

export const taskHelper = {
    isEmptyObject,
    convertToObject,
};

function isEmptyObject(obj) {
    return Object.keys(obj).length === 0;
}

function convertToObject(obj) {
    if (typeof obj != 'undefined' && obj.length > 0) {
        var object = obj.reduce(
        (obj, item) => Object.assign(obj, { [item.id]: item.id }), {});
        return object;
    }else{
        return {};
    }
}



// async function fetchData() {
//     try {
//       const response = await axios.get('/api/data');
//       return response.data;
//     } catch (error) {
//       console.error(error);
//       throw error;
//     }
//   }
  
//   export default {
//     data() {
//       return {
//         data: null,
//       };
//     },
//     async mounted() {
//       try {
//         this.data = await fetchData();
//       } catch (error) {
//         console.error(error);
//       }
//     },
//   };