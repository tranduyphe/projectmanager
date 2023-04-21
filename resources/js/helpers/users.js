export const userHelper = {
    fullName,
    avatar
};
function fullName(data){
    if (data.first_name || data.last_name){
        if (data.first_name && !data.last_name) {
            return data.first_name
        }else if(!data.first_name && data.last_name){
            return data.last_name
        }else{
            return data.first_name+' '+data.last_name
        }
    }else{
        return data.name
    };
};
function avatar(url){
    var avatar = 'images/avatar.png';
    var path   = process.env.PUBLIC_URL;
    var src    = path+avatar
    if (url) {
        src = path+'users/'+url;
    }
    return src;
}