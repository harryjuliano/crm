import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Card from '@/Components/Card'
import Input from '@/Components/Input'
import Button from '@/Components/Button'

export default function Create() {
  const { data, setData, post, errors } = useForm({
        opportunity_id: '',
        item_type: '',
        description: '',
        qty: '',
        estimated_price: '',
        estimated_discount_percent: '',
        subtotal: '',
  })

  const submit = (e) => {
    e.preventDefault()
    post(route('apps.opportunity-items.store'))
  }

  return (
    <>
      <Head title='Tambah Opportunity Item' />
      <Card title='Tambah Opportunity Item' form={submit} footer={<Button type='submit' label='Simpan' variant='gray' />}>
        <div className='grid grid-cols-1 md:grid-cols-2 gap-4'>
              <div className='w-full md:w-1/2'>
                <Input label='Opportunity ID' type='text' value={data.opportunity_id} onChange={e => setData('opportunity_id', e.target.value)} errors={errors.opportunity_id} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Item Type' type='text' value={data.item_type} onChange={e => setData('item_type', e.target.value)} errors={errors.item_type} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Deskripsi' type='text' value={data.description} onChange={e => setData('description', e.target.value)} errors={errors.description} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Qty' type='text' value={data.qty} onChange={e => setData('qty', e.target.value)} errors={errors.qty} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Harga' type='text' value={data.estimated_price} onChange={e => setData('estimated_price', e.target.value)} errors={errors.estimated_price} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Disc %' type='text' value={data.estimated_discount_percent} onChange={e => setData('estimated_discount_percent', e.target.value)} errors={errors.estimated_discount_percent} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Subtotal' type='text' value={data.subtotal} onChange={e => setData('subtotal', e.target.value)} errors={errors.subtotal} />
              </div>
        </div>
      </Card>
    </>
  )
}

Create.layout = page => <AppLayout children={page} />
