import axios from "axios";

export function login(credentials){
    return new Promise((res, rej)=>{
        axios.post('/api/auth/login', credentials)
            .then((response)=>{
                res(response.data);
            })
            .catch((error) => {
                rej("Wrong email or password");
            });
    });
}

export function register(user_data){
    return new Promise((res, rej)=>{
        axios.post('/api/auth/register', user_data)
            .then((response)=>{
                res(response.data);
            })
            .catch((error) => {
                rej(error);
            });
    });
}


export function getLocalUser(){
    const userStr  = localStorage.getItem("user");

    if(!userStr){
        return null;
    }

    return JSON.parse(userStr);
}
