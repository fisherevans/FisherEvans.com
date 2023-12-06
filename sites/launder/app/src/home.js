import React from "react"
import { useNavigate } from "react-router-dom";
import { useEffect } from 'react';
import { checkPassword, checkUsername } from "./password.js";

const Home = (props) => {
    const { username, password, acctSeed, acctFactor } = props
    const navigate = useNavigate();
    
    const v_123 = 3;

    var n=0;
    for(var i = 0;i < acctSeed.length;i++){
        n+=acctSeed.charCodeAt(i);
    }
    console.log(n + " - " + acctFactor)
    const acct = n * acctFactor

    const onButtonClick = () => {
        if (validAuth()) {
            localStorage.removeItem("user")
             props.setUsername("")
             props.setPassword("")
        } else {
            navigate("/login")
        }
    }

    const validAuth = () => {
        try {
            checkPassword(password)
            checkUsername(username)
            return true
        } catch(e) {}
        return false
    }

    return <div>
        {validAuth() ? (
            <div className={"mainContainer"}>
                <div className={"nav"}>
                    <img src="lru-logo-slim.png" />
                    <div className="logout">
                        <input
                            className={"inputButton"}
                            type="button"
                            onClick={onButtonClick}
                            value={"Logout"} />
                    </div>
                </div>
                <div className={"welcome"}>
                    Welcome, Fisher!
                </div>
                <div className="cols">
                    <div className="col">
                        <div className="subheader">
                            Account Details
                        </div>
                        <table>
                            <tr><td className="name">Name:</td><td>Fisher Evans</td></tr>
                            <tr><td className="name">Account #:</td><td>{(acct << v_123) % 1000}</td></tr>
                            <tr><td className="name">Fake Name:</td><td>Phisher Evins</td></tr>
                            <tr><td className="name">Currency:</td><td>Snow Gold</td></tr>
                            <tr><td className="name">Beneficiary:</td><td>Lisa Evans</td></tr>
                        </table>
                    </div>
                    <div className="col">
                        <div className="subheader">
                            Service Summary
                        </div>
                        <table>
                            <tr><td className="name">Amount Laundered:</td><td>$48,500.00</td></tr>
                            <tr><td className="name">Total Charges:</td><td>$5,847.34</td></tr>
                            <tr><td className="name">Coupons Applied:</td><td>$2,000.00</td></tr>
                            <tr><td className="name">Balance Due:</td><td>$0.00</td></tr>
                            <tr><td className="name">Deposity Method:</td><td>ACH Direct</td></tr>
                        </table>
                    </div>
                </div>
                <div className="subheader">
                    Status
                </div>
                <div className="subtitle">
                    No current services. Call Joe to initiate a new scheme. You should have his business card somewhere...
                </div>
                <div className="subheader">
                    News
                </div>
                <div className="subtitle">
                    We've sent all of our valued customers a special holiday present! Check you mail boxes. Call our main office if you don't remember the pass code used for gifts we send you.
                </div>
            </div>
        ):(
            <div className={"loginContainer"}>
                <div className="titleContainer">
                    <img className="loginLogo" src="./lru-logo.png" />
                </div>
                <div className="subheader">
                    We'll clean your money.
                </div>
                <input
                    className={"inputButton"}
                    type="button"
                    onClick={onButtonClick}
                    value={"Log in"} />
                    <div className={"disclaimer"}>This is a satirical joke site. Do not launder money. It is a crime.</div>
            </div>  
        )}

    </div>
}

export default Home
