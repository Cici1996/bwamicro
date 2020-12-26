const apiAdafter = require("../../apiAdafter");
const { URL_SERVICE_MEDIA } = process.env;

const api = apiAdafter(URL_SERVICE_MEDIA);

module.exports = async(req,res) => {
    try{
        const media = await api.post('/media',req.body);
        return res.json(media.data);
    }catch(err){

        if(err.code === "ECONNREFUSED"){
            return res.status(500).json({status:"error",message:"Service Unavailable"});
        }

        const {status,data} = err.response;
        return res.status(status).json(data);
    }
}