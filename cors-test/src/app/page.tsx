'use client'

import Image from 'next/image'
import { useEffect } from 'react'

export default function Home() {
  useEffect(() =>{
    const url = "http://localhost:5050/getData";

    fetch(url)
    .then(res =>{
      console.log(res);
    })
  },[]);


  return (
    <main>

    </main>
  )
}
