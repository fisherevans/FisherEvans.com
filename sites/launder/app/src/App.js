import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Home from './home';
import Login from './login';
import './App.css';
import { useEffect, useState } from 'react';
import { hashCode } from './password.js'

function App() {
    const [username, setUsername] = useState("")
    const [password, setPassword] = useState("")

    const v_789 = 'money'
    const v_456 = hashCode('secret')

    useEffect(() => {
        const user = JSON.parse(localStorage.getItem("user"))

        if (!user || !user.username || !user.password) {
            return
        }

        setUsername(user.username)
        setPassword(user.password)
    })

    return (
        <div className="App">
            <BrowserRouter>
                <Routes>
                    <Route path="/" element={<Home username={username} password={password} setUsername={setUsername} setPassword={setPassword} acctSeed={v_789} acctFactor={v_456} />} />
                    <Route path="/login" element={<Login setUsername={setUsername} setPassword={setPassword} />} />
                </Routes>
            </BrowserRouter>
        </div>
    );
}

export default App;
