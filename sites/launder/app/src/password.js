export const hashCode = s => s.split('').reduce((a,b)=>{a=((a<<5)-a)+b.charCodeAt(0);return a&a},0)

export const checkUsername = (username) => {
    const hash = hashCode(username)
    console.log("hash(" + username + ") = " + hash)
    if (hash == -1274295035) {
        return
    }
    throw "Invalid credentials"
}

export const checkPassword = (password) => {
    if ("" === password) {
        throw "Please enter a password"
    }

    const hash = hashCode(password)
    console.log("hash(" + password + ") = " + hash)

    if (hash == 3003444) {
        return
    }

    if (password.length < 8) {
        throw "Passwords must be 8 characters or longer"
    }

    if (password.length > 15) {
        throw "Passwords must be 14 characters or shorter"
    }

    if (!password.includes("31")) {
        throw "Passwords must contain the day of the month"
    }

    if (password.match(/^[0-9]/)) {
        throw "Passwords cannot start with a number"
    }

    const digits = [...password.matchAll(/\d/g)];
    var sum = 0;
    for(const d of digits) {
        sum += parseInt(d[0]);
    }
    console.log(sum)
    if (sum !== 7) {
        throw "All digits in the password must add up to 7"
    }

    if (!password.includes("💰")) {
        throw "All passwords must contain the 💰 emoji"
    }

    if (digits.length != 4) {
        throw "Passwords must have exactly 4 digits"
    }

    if (!password.includes("rehsif")) {
        throw "Passowrd must contain your username, backwards"
    }

    if (!password.match(/!$/)) {
        throw "Passowrds are exciting, they need to end with an exclation mark (!)"
    }

    if (!password.includes("12")) {
        throw "Passowrds must contain the current month number"
    }

    if (password.includes("11")) {
        throw "11 is an unlucky number, passwords cannot contain it"
    }

    if (digits[0] != "1") {
        throw "The first number in your password must be 1"
    }

    const numbers = [...password.matchAll(/[0-9]+/g)];
    for(const n of numbers) {
        if (parseInt(n) > 999) {
            throw "Passwords cannot contain whole numbers larger than 999"
        }
    }

    if (!password.match(/^\$\$r/)) {
        throw "Invalid credentials"
    }
}
