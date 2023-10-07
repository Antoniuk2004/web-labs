'use client'

import { FC, useState, useEffect, ChangeEvent, KeyboardEventHandler } from "react";

import { useRouter } from "next/navigation";

import { AiOutlineSearch } from 'react-icons/ai';

import { BsPerson, BsCart3 } from 'react-icons/bs';

interface PageProps {
    params: { name: string }
}

type Product = {
    name: string;
    price: number;
    image: string;
};


const Page: FC<PageProps> = ({ params }) => {
    const name = params.name;

    const [data, setData] = useState<Product[]>([]);
    const [inputValue, setInputValue] = useState(name);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const link = `http://localhost:7070/getData?name=${name}`;
                const response = await fetch(link);

                const json = await response.json();
                const data = json.data;

                setData(data);
            }
            catch (error) {
                console.error(error);
            }
        }

        fetchData();
    }, []);


    function handleInput(event: ChangeEvent<HTMLInputElement>) {
        const value = event.currentTarget.value;
        setInputValue(value);
    }

    const handleKeyPress: KeyboardEventHandler<HTMLInputElement> = (event) => {
        const key = event.code;
        if (key === "Enter") {
            router.push(inputValue);
        }
    }

    const router = useRouter();

    return (
        <main>
            <div className="searchbar">
                <div className="form">
                    <AiOutlineSearch className='search-icon' />
                    <input className="product-input" value={inputValue} onChange={handleInput} onKeyDown={handleKeyPress} type="text" />
                    <button onClick={() => router.push(inputValue)} className="input-button">Знайти</button>
                    <BsPerson className='profile-icon' />
                    <BsCart3 className='store-icon' />
                </div>
            </div>
            <div className="wrapper">
                <div className="products">

                    {data.length == 0 ? "yes" : "no"}
                    {data.map((element, index) => (
                        <div key={index} className="one-product">
                            <img className="product-image" src={`http://localhost:7070/${element.image}`} alt="image" />
                            <p className="product-name">{element.name}</p>
                            <p className="product-price">{element.price}$</p>
                        </div>
                    ))}
                </div>
            </div>
        </main>
    );
};

export default Page;