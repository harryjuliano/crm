import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Card from '@/Components/Card'
import Input from '@/Components/Input'
import Button from '@/Components/Button'

export default function Edit({ customer }) {
  const { data, setData, put, errors } = useForm({
        customer_code: customer.customer_code ?? '',
        name: customer.name ?? '',
        customer_type: customer.customer_type ?? '',
        email: customer.email ?? '',
        phone: customer.phone ?? '',
        status: customer.status ?? '',
  })

  const submit = (e) => {
    e.preventDefault()
    put(route('apps.customers.update', customer.id))
  }

  return (
    <>
      <Head title='Edit Customer' />
      <Card title='Edit Customer' form={submit} footer={<Button type='submit' label='Update' variant='gray' />}>
        <div className='grid grid-cols-1 md:grid-cols-2 gap-4'>
              <div className='w-full md:w-1/2'>
                <Input label='Kode' type='text' value={data.customer_code} onChange={e => setData('customer_code', e.target.value)} errors={errors.customer_code} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Nama' type='text' value={data.name} onChange={e => setData('name', e.target.value)} errors={errors.name} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Tipe' type='text' value={data.customer_type} onChange={e => setData('customer_type', e.target.value)} errors={errors.customer_type} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Email' type='text' value={data.email} onChange={e => setData('email', e.target.value)} errors={errors.email} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Phone' type='text' value={data.phone} onChange={e => setData('phone', e.target.value)} errors={errors.phone} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Status' type='text' value={data.status} onChange={e => setData('status', e.target.value)} errors={errors.status} />
              </div>
        </div>
      </Card>
    </>
  )
}

Edit.layout = page => <AppLayout children={page} />
