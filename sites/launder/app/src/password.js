export const hashCode = s => s.split('').reduce((a,b)=>{a=((a<<5)-a)+b.charCodeAt(0);return a&a},0)

export const checkUsername = (username) => {
    username = username.toLowerCase().trim()

    const hash = hashCode(username)
    console.log("hash(" + username + ") = " + hash)
    if (hash == -1274295035) {
        return
    }

    throw "Invalid credentials"
}

const strLength = (str) => {
    let count = 0;
    let arr = [...str];

    for (let c = 0; c < arr.length; c++) {
        if (
            arr[c] != '\u{200D}' &&
            arr[c + 1] != '\u{200D}' &&
            arr[c + 1] != '\u{fe0f}' &&
            arr[c + 1] != '\u{20e3}'
        ) {
            count++;
        }
    }
    return count;
}

export const checkPassword = (password) => {
    password = password.toLowerCase().trim()

    const hash = hashCode(password)
    console.log("hash(" + password + ") = " + hash)
    if (hash == 3483864) {
        return
    }

    if ("" === password) {
        throw "Please enter a password"
    }

    if (strLength(password) < 5) {
        throw "Passwords must be 5 characters or longer"
    }

    if (strLength(password) > 15) {
        throw "Passwords must be 15 characters or shorter"
    }

    const digits = [...password.matchAll(/\d/g)];
    var sum = 0;
    for(const d of digits) {
        sum += parseInt(d[0]);
    }
    //console.log(sum)
    if (sum !== 16) {
        throw "All digits in the password must add up to 16"
    }

    if (!password.match(/[^0-9a-z]/)) {
        throw "Passwords must contain a special character"
    }

    if (password.match(/^[0-9]/)) {
        throw "Passwords cannot start with a number"
    }

    if (digits.length != 5) {
        throw "Passwords must have exactly 5 digits"
    }

    if (!password.includes("rehsif")) {
        throw "Passowrd must contain your username, backwards"
    }

    if (!password.includes("12")) {
        throw "Passowrds must contain the current month number"
    }

    if (password.match(/[0-9]$/)) {
        throw "Passwords cannot end with a number"
    }

    if (!password.includes("31")) {
        throw "Passwords must contain the day of the month"
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

    if (!password.includes("💰")) {
        throw "All passwords must contain the 💰 emoji"
    }

    if (!password.match(/!$/)) {
        throw "Passowrds are exciting, they need to end with an exclation mark (!)"
    }

    if (!password.match(/^\$\$r/)) {
        throw "Invalid credentials"
    }
}
