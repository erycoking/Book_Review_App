import axios from "axios";

/**
 * login user
 *
 * @param {user input} credentials
 * @returns Promise of loggedin user and token and stores them in localStorage
 */
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

/**
 * register user
 *
 * @param {user input} user_data
 * @returns Promise of newly added user and token and stores them in localStorage
 */
export function register(user_data){
    return new Promise((res, rej)=>{
        axios.post('/api/auth/register', user_data, {
            headers: {
                'Content-Type' : 'multipart/form-data'
            }
        })
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
