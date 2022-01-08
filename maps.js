function getRoute(pincode){
    let coordinates = {};
    let latitude,longitude;
    async function pincodeToCoordinates(){
    async function getCoordinates(address){       
    const response= await fetch(`https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${YOUR-API-KEY}`);
        const data = await response.json();
        latitude=data.results[0].geometry.location.lat;
        longitude=data.results[0].geometry.location.lng;
    }
    await getCoordinates(pincode).then(() => {
        coordinates.lat=latitude;
        coordinates.lng=longitude;
    })
    }

    pincodeToCoordinates().then(()=>{
    return coordinates;
    });    
}

getRoute(248001);
