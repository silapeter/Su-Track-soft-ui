import { useState } from "react";

function useUniqueCodeGenerator(length = 5) {
    const [generatedCodes, setGeneratedCodes] = useState(new Set());
    const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    const maxCodes = Math.pow(characters.length, length);

    const generateUniqueCode = () => {
        if (generatedCodes.size >= maxCodes) {
            throw new Error("รหัสทั้งหมดถูกใช้ไปแล้ว!");
        }

        let newCode;
        do {
            newCode = Array.from({ length }, () =>
                characters[Math.floor(Math.random() * characters.length)]
            ).join("");
        } while (generatedCodes.has(newCode));

        setGeneratedCodes((prev) => new Set(prev).add(newCode));
        return newCode;
    };

    return generateUniqueCode;
}

export default useUniqueCodeGenerator;
