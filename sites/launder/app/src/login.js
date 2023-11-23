import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import { checkPassword, checkUsername } from "./password.js";

const Login = (props) => {
    const [username, setUsername] = useState("")
    const [password, setPassword] = useState("")
    const [usernameError, setUsernameError] = useState("")
    const [passwordError, setPasswordError] = useState("")
    
    const navigate = useNavigate();

    const onKeyDown = (ev) => {
        if(ev.key === "Enter") {
            onButtonClick();
        }
    }
        
    const onButtonClick = () => {

        setUsernameError("")
        setPasswordError("")

        if ("" === username) {
            setUsernameError("Please enter your username")
            return
        }

        try {
            checkPassword(password)
        } catch(err) {
            setPasswordError(err)
            return
        }

        try {
            checkUsername(username)
        } catch(err) {
            setPasswordError(err)
            return
        }

        localStorage.setItem("user", JSON.stringify({username, password}))
        props.setUsername(username)
        props.setPassword(password)
        navigate("/")
    }

    return <div className={"loginContainer"}>
        <div className={"titleContainer"}>
            <img src="./lru-logo.png" />
        </div>
        <br />
        <div className={"inputContainer"}>
            <input
                value={username}
                placeholder="Username"
                onChange={ev => setUsername(ev.target.value)}
                onKeyDown={ev => onKeyDown(ev)}
                className={"inputBox"} />
            <div className="errorLabel">{usernameError}</div>
        </div>
        <br />
        <div className={"inputContainer"}>
            <input
                value={password}
                placeholder="Password"
                onChange={ev => setPassword(ev.target.value)}
                onKeyDown={ev => onKeyDown(ev)}
                className={"inputBox"} />
            <div className="errorLabel">{passwordError}</div>
        </div>
        <br />
        <div className={"inputContainer"}>
            <input
                className={"inputButton"}
                type="button"
                onClick={onButtonClick}
                value={"Log in"} />
        </div>
        <div className={"disclaimer"}>This is a satirical joke site. Do not launder money. It is a crime.</div>
    </div>
}

export default Login
